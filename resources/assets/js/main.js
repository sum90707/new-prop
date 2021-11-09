window.urlParam = function(name) {
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results ? results[1] : '';
}


window.stringReplace = function (path, parameters) {
	$.each(parameters, function (parameter, value) {
		path = path.replace(new RegExp(parameter, 'g'), value);
	})
    
	return path;
}

window.triggerAJAX = function (config, $this) {
	
	url =  config.data ? stringReplace(config.url, {'__DATA__' : $this.data(config.data)}) : config.url
	
	$.ajax({
		url: url ? url : config.url,
		type: config.method ? config.method : 'GET',
		headers: {
			'X-CSRF-TOKEN': config.token
		},
		data: config.postData ?  config.postData : {},
		success: function success(json, status, xhr) {
			config.callback(json, config)
		}
	}).fail(
		function (xhr) {
			
		}
	);
}

