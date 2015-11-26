document.observe("dom:loaded", function() {
    $("b_xml").observe("click", function(){
    	//construct a Prototype Ajax.request object
    	new Ajax.Request("songs_xml.php",{
    		method: "GET",
    		parameters: {top: $F("top")},
    		onSuccess: showSongs_XML,
    		onFailure: ajaxFailed,
    		onException: ajaxFailed
    	});
    });
    $("b_json").observe("click", function(){
        //construct a Prototype Ajax.request object
        new Ajax.Request("songs_json.php",{
            method: "GET",
            parameters: {top: $F("top")},
            onSuccess: showSongs_JSON,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        });
    });
});

function showSongs_XML(ajax) {
    var XMLcode =ajax.responseXML;
    var beforeNode =document.getElementById("songs");

    while (beforeNode.firstChild) {
        beforeNode.removeChild(beforeNode.firstChild);
    }

    for (var i =0; i <XMLcode.getElementsByTagName("title").length; i++) {
       var result ="";
       var title =XMLcode.getElementsByTagName("title")[i].firstChild.nodeValue;
       var artist =XMLcode.getElementsByTagName("artist")[i].firstChild.nodeValue;
       var genre =XMLcode.getElementsByTagName("genre")[i].firstChild.nodeValue;
       var time =XMLcode.getElementsByTagName("time")[i].firstChild.nodeValue;

       result ="<li>" +title +" - " +artist +" [" +genre +"] (" +time +")</li>";
       $("songs").insert(result);
    }  
}

function showSongs_JSON(ajax) {
	var JSONcode =JSON.parse(ajax.responseText);
    var beforeNode =document.getElementById("songs");

    while (beforeNode.firstChild) {
        beforeNode.removeChild(beforeNode.firstChild);
    }

    for (var i =0; i <JSONcode.songs.length; i++) {
        var li =document.createElement("li");
        var result ="";

        result =JSONcode.songs[i].title +" - " +JSONcode.songs[i].artist +" [" +JSONcode.songs[i].genre +"] (" +JSONcode.songs[i].time +")";
        li.innerHTML =result;
        $("songs").appendChild(li);
    }
	
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}
