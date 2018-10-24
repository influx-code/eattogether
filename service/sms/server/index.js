const bluebird = require('bluebird')
const Redis = require('redis')
const redisConfig = require('./config/redis')

let redis

connectRedis()

/**
 * 连接redis
 * @return {[type]} [description]
 */
function connectRedis() {
	console.log(redisConfig)
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

	console.log('Connect to redis.')
}
