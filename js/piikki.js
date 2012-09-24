$(document).ready(function() {

	$.ajax('data.php', {
		type : 'post',
		async : false,
		cache : false,
		data : 'action=users',
		dataType : 'json'
	}).success(function(data) {
		console.log('test');
		$.each(data, function(i, item) {
			$('section[name=login]').append('<button type="button" class="user" name="' + item + '">' + item + '</button>');
		});

	});

	var loginContainer = $('.login');

	//setup fancybox
	$('.fancybox').fancybox({
		autoSize : false,
		beforeLoad : function() {
			this.width = $(document).width() / 2;
			this.height = $(document).height() / 1.5;
		},
		afterClose : function() {
			var loggedUser = $.data(loginContainer, 'user');
			if (loggedUser == undefined) {
				$('.loggedUser').html('(not logged in)');
			} else {
				$('.loggedUser').html('Moi ' + loggedUser);
			}
		}
	});

	//force user selection, if not "logged" in
	if ($.data(loginContainer, 'user') == undefined)
		$('.fancybox').click();

	//read user selection
	$('.user').click(function() {
		console.log('testi');
		$.data(loginContainer, 'user', $(this).attr('name'));
		loadUserData();
		$.fancybox.close();
	});

	//update all data fields and save data to database
	function refresh() {
		$('#accountValue').html($.data(loginContainer, 'accountValue'));

	}

	//buying a product functionality
	$('.product').click(function() {
		var productPrice = parseFloat($(this).attr('value'));
		saveData(productPrice);
	});

	function saveData(price) {
		$.post('data.php', {
			'action' : 'save',
			'user' : $.data(loginContainer, 'user'),
			'amount' : price
		}, function(data) {
			$.data(loginContainer, 'accountValue', parseFloat(data['accountValue']));
			refresh();
		}, 'json');
	}

	function loadUserData() {
		$.post('data.php', {
			'action' : 'userData',
			'user' : $.data(loginContainer, 'user')
		}, function(data) {
			$.data(loginContainer, 'accountValue', parseFloat(data['accountValue']));
			refresh();
		}, 'json');
	}

});
