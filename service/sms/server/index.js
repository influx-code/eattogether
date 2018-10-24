const bluebird = require('bluebird')
const Redis = require('redis')
const SmsSdk = require('@alicloud/sms-sdk')
const utils = require('./utils')

const constant = require('./config/constant')

let redis,
	sms

main()

async function main() {
	connectRedis()
	connectSms()

	await startWorker()
}

/**
 * 连接redis
 * @return {[type]} [description]
 */
function connectRedis() {
	const redisConfig = require('./config/redis')
	let options = {
		host: redisConfig['host'],
		port: redisConfig['port'],
		prefix: redisConfig['prefix']
	}
	if (redisConfig['password']) {
		options['password'] = redisConfig['password']
	}

	redis = Redis.createClient(options)
	bluebird.promisifyAll(redis)

	utils.info('Connect to redis.')
}

/**
 * 创建sms服务
 * @return {[type]} [description]
 */
function connectSms() {
	const smsConfig = require('./config/sms')
	
	let options = {
		'accessKeyId': smsConfig['accessKeyId'],
		'secretAccessKey': smsConfig['secretAccessKey']
	}
	sms = new SmsSdk(options)

	utils.info('Connect to sms.')
}

/**
 * 开始消化
 * @return {[type]} [description]
 */
async function startWorker() {
	while (true) {
		let job
		let cache = await redis.rpopAsync(constant['CACHE_SMS_QUEUE'])

		/** 队列为空 */
		if (!cache) {
			utils.log(`短信队列为空, 等待 ${constant['SPARE_DELAY'] / 1000} 秒`)
			await utils.sleep(constant['SPARE_DELAY'])
			continue
		}

		/** decode缓存数据 */
		try {
			job = JSON.parse(cache)
		} catch (error) {
			utils.error('错误的短信任务数据', cache)
			console.trace(error)
			continue
		}

		await sendSms(job)
	}
}

/**
 * 发送短信
 * @param  {[type]} job [description]
 * @return {[type]}     [description]
 */
async function sendSms(job) {
	let { mobile, template_code, template_param } = job

	/** 检查短信发送参数 */
	if (!mobile || !template_code || !template_param) {
		utils.error('缺少必要参数', job)
		return false
	}

	/** 组合短信发送参数 */
	let options = {
		'PhoneNumbers': mobile,
		'TemplateCode': template_code,
		'TemplateParam': JSON.stringify(template_param),
	}

	utils.log('发送短信', options)
	return await new Promise((resolve, reject) => {
		sms.sendSMS(options).then((res) => {
			if (res.Code == 'OK') {
				utils.log('短信发送成功')
				return resolve(true)
			}

			return reject(res)
		}, (err) => {
			return reject(err)
		})
	}).catch((err) => {
		utils.error('短信发送失败')
		console.trace(err)
		return false
	})
}