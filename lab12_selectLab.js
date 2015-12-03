"use strict";

document.observe("dom:loaded", function() {
	// 필요한 모든 element들을 Draggabble 혹은 Droppables로 만드시오 
	// 	(힌트 $$ 함수를 사용하여 모든 image들을 찾으시오). 
	// 모든 Droppables는 'onDrop' 이벤트 발생시 'labSelect' function을 부르도록 작성 하시오. 
	//  (힌트: revert옵션을 적절히 지정하시오!) 

	var images =$$("#labs > img");

	for (var i =0; i <images.length; i++) {
		new Draggable(images[i], {revert: true});
	}

	Droppables.add("labs", {onDrop: labSelect});
	Droppables.add("selectpad", {onDrop: labSelect});
});

function labSelect(drag, drop, event) {
	// 이 event-handler function을 작성하시오.
	if (drop.id =="selectpad" && drag.parentNode ==$("labs") && $$("#selection > li").length <3) {
		$("labs").removeChild(drag);
		$("selectpad").appendChild(drag);

		var listItem ="";
		listItem ="<li id=\"" +drag.alt +"\">" +drag.alt +"</li>";
		$("selection").insert(listItem);
		$(drag.alt).pulsate({
			delay: 0.5,
			duration: 1.0
		});
	}

	else if (drop.id =="labs" && drag.parentNode ==$("selectpad")) {
		$("selectpad").removeChild(drag);
		$("selection").removeChild($(drag.alt));
		$("labs").appendChild(drag);	
	}
}
