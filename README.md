Piikkilista

a simple app for handling peoples tabs

https://github.com/spiikki/piikkilista
(c) Spiikki Sillanpää 2012

uses fancyBox ( http://fancyapps.com/fancybox/ )
Copyright (c) 2012 Janis Skarnelis

Requirements:
	Apache
	PHP (developed and tested on PHP5)
	JavaScript capable browser

Required files:
	storage.json (o+rw)
	- JSON database
	storage.log (o+rw)
	- empty file with write permission

How-To Configure

	First you have to setup storage.json. This will give you users/tabs.
		- create JSON-file into root of piikkilista
		- format is single-line JSON:
		{"user":{"accountValue":float_value}}
		- MUST BE WRITABLE BY APACHE or other http-server

	Then create a storage.log. (touch storage.log)
		- Keeps log of activity
		- MUST BE WRITABLE BY APACHE or other http-server

	Then you have to add products to index.html. One sample is given for
	example.

	Good to go! Have fun.
