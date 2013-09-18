$(document).ready(function() {

	$.ajax('data.php', {
		type : 'post',
		async : false,
		cache : false,
		data : 'action=users',
		dataType : 'json'
	}).success(function(data) {
		$.each(data, function(i, item) {
			$('section[name=login]').append('<button type="button" class="user" name="' + item + '">' + item + '</button>');
		});

	});

	var loginContainer = $('.login');

	//setup fancybox
	$('.fancybox').fancybox({
		autoSize : false,
		beforeLoad : function() {
			this.width = $(document).width() / 1.5;
			this.height = $(document).height();
		},
		afterClose : function() {
			var loggedUser = $.data(loginContainer, 'user');
			if (loggedUser == undefined) {
				$('.loggedUser').html('(not logged in)');
			} else {
				$('.loggedUser').html('Hello ' + loggedUser);
			}
		}
	});

	//setup fancybox for notify
	$('.fancyboxNotify').fancybox({
		autoSize : false,
		beforeLoad : function() {
			this.width = $(document).width() / 1.5;
			this.height = $(document).height();
		},
		afterShow : function() {
			// close after 2 seconds
			setTimeout(function(){
				$.fancybox.close();
			}, 2000);
		}
	});

	//force user selection, if not "logged" in
	if ($.data(loginContainer, 'user') == undefined)
		$('.fancybox').click();

	//read user selection
	$('.user').click(function() {
		$.data(loginContainer, 'user', $(this).attr('name'));
		loadUserData();
		$.fancybox.close();
	});

	//update all data fields and save data to database
	function refresh() {
		$('.accountValue').html($.data(loginContainer, 'accountValue'));
	}

	//buying a product functionality
	$('.product').click(function() {
		var productPrice = parseFloat($(this).attr('value'));
		var productName = $(this).attr('name');
		saveData(productName, productPrice, 'sale');
	});

	//deposit to account functionality
	$('#deposit').click(function() {
		saveData('lataus', $('#depositValue').attr('value'), 'deposit');
	});

	// make transaction
	function saveData(product, price, type) {
		$.post('data.php', {
			'action' : 'save',
			'user' : $.data(loginContainer, 'user'),
			'amount' : price,
			'product': product,
			'type' : type
		}, function(data) {
			// update user data
			$.data(loginContainer, 'accountValue', parseFloat(data['accountValue']));
			refresh();
			//notify user for successful transaction
			notify(product);
		}, 'json');
		
	}

	// load users
	function loadUserData() {
		$.post('data.php', {
			'action' : 'userData',
			'user' : $.data(loginContainer, 'user')
		}, function(data) {
			$.data(loginContainer, 'accountValue', parseFloat(data['accountValue']));
			refresh();
		}, 'json');
	}
	
	// display notifier after transaction 
	function notify(productName) {
		// set notify data
		$('span[id="productName"]').html(productName);
		$('.fancyboxNotify').click();
	}

});
