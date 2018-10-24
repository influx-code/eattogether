if (process.env.APP_ENV == 'local') {
	module.exports = {
		'host': 'redis',
		'port': '6379',
		'password': '',
		'prefix': 'EAT_TOGETHER:'
	}	
} else if (process.env.APP_ENV == 'development'){
	module.exports = {
		'host': '192.168.10.10',
		'port': '6379',
		'password': '',
		'prefix': 'EAT_TOGETHER:'
	}	
} else if (process.env.APP_ENV == 'production'){
	module.exports = {
		'host': '192.168.10.10',
		'port': '6379',
		'password': '',
		'prefix': 'EAT_TOGETHER:'
	}	
}
