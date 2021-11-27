/*
Config file
 */

var config = {
	parsitcenuBydem: true, //Цены true  CSGOFAST ,false со своей бд!
	name: 'CSGOW.RU',
    mysql: {
        host: '127.0.0.1',
        user: 'root',
		pass: 'Nikitalox646431',
		database: 'csgow'
    },  
    bot: {
        username: 'nikita64643',
        password: 'Pomalox646431',
		steamid: '76561198110720048',
		shared_secret: 'jfqVg7UXadSkFm7qI9dy94Qwvu0=',
		identity_secret: 'ffshCCU8dxDx53UDPy4K2ce53s8=',
	    CancelOffer: 3000000,
		gametime: 120
    }, 
    shopBot: {
        username: 'a111nsg77',
        password: 'A77gsj12',
		steamid: '76561198330780241',
		shared_secret: 'b\/sq\/j4OYpQ7PuJXrhhkzKUoB0s=',
		identity_secret: 'a1nXhVn3Zqn8VXPd96+DmcCb5bo=',
	    CancelOffer: 3000000,
    },
    domain: 'csgow.ru',
	port: 2052,
	keytm: 't66dFb2h6dS6yWFqLDpf2x0LLIa3oZ5',
    admins: [
        '76561198135175020',''
    ]
}
module.exports = config;