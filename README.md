Piikkilista

a simple app for handling peoples tabs

(c) Spiikki Sillanpää 2012

Requirements:
	Fancybox ( http://fancyapps.com/fancybox/ )
	- place the source folder into root of piikkilista

	storage.json
	- create JSON-file into root of piikkilista
	- format is single-line JSON:
	{"user":{"accountValue":float_value}}
	- MUST BE WRITABLE BY APACHE or other http-server

	storage.log
	- empty file with write permission
