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