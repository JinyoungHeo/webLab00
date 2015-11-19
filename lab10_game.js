"use strict";

var numberOfBlocks = 9;
var targetBlocks = [];
var trapBlock;
var targetTimer;
var trapTimer;
var instantTimer;


document.observe('dom:loaded', function(){
	$("start").observe("click", function(){
		var allBlock =$$(".block");
		for (var i =0; i <allBlock.length; i++) {
			if (allBlock[i].hasClassName("target")) {
				allBlock[i].removeClassName("target");
			}

			else if (allBlock[i].hasClassName("trap")) {
				allBlock[i].removeClassName("trap");
			}
		}

		$("state").textContent ="Ready!";
		$("score").textContent ="0";
		//reset timer
		clearInterval(targetTimer);
		targetTimer =null;
		clearInterval(trapTimer);
		trapTimer =null;
		clearInterval(instantTimer);
		instantTimer =null;
		instantTimer =setTimeout(startGame, 3000);
	});

	$("stop").observe("click", stopGame);
});

function startGame(){
	targetBlocks =[];
	trapBlock =[];
	clearInterval(targetTimer);
	targetTimer =null;
	clearInterval(trapTimer);
	trapTimer =null;
	clearInterval(instantTimer);
	instantTimer =null;
	startToCatch();
}

function stopGame(){
	$("state").textContent ="Stop";
	targetBlocks =[];
	trapBlock =[];
	clearInterval(targetTimer);
	targetTimer =null;
	clearInterval(trapTimer);
	trapTimer =null;
	clearInterval(instantTimer);
	instantTimer =null;
}

function startToCatch(){
	$("state").textContent ="Catch!";
	var blocks =$$(".block");
	var wrongTimer;
	var score =0;

	blocks.sort(function(){ 
		return Math.random() -Math.random()
	});

	showTarget(blocks);
	showTrap(blocks);

	//event hadler ex5
	var allBlock =$$(".block");

	for (var i =0; i <allBlock.length; i++) {
		allBlock[i].observe("click", function() {
			clearInterval(wrongTimer);
			wrongTimer =null;

			if (this.hasClassName("target") && !this.hasClassName("trap")) {
				score =20;
				this.removeClassName("target");
				blocks.push(this);
				targetBlocks.pop();
				blocks.sort(function(){ 
					return Math.random() -Math.random()
				});				
			}

			else if (this.hasClassName("trap")) {
				score =-30;
				this.removeClassName("trap");
			}

			else {
				score =-10;
				this.addClassName("wrong");
				wrongTimer =setInterval(function(){
					//this.removeClassName("wrong");
					var allBlock =$$(".block");
					for (var i =0; i <allBlock.length; i++) {
						if (allBlock[i].hasClassName("wrong")) {
							allBlock[i].removeClassName("wrong");
						}
					}
				}, 100);
			}

			$("score").textContent =parseFloat($("score").textContent) +score;
		});	
	}
}

function showTarget(b) {
	b.sort(function(){ 
		return Math.random() -Math.random()
	});

	targetTimer =setInterval(function(){
		targetBlocks.push(b.last());
		b.pop();
		targetBlocks.last().addClassName("target");

		if (targetBlocks.length >4) {
			//all timer stop
			clearInterval(targetTimer);
			targetTimer =null;
			clearInterval(trapTimer);
			trapTimer =null;
			clearInterval(instantTimer);
			instantTimer =null;
			alert("you lose");
			alert(targetBlocks);
			//detach event handler
			var allBlock = $$(".block");
			for(var i =0; i <allBlock.length; i++){
				allBlock[i].stopObserving();
			}		
		}
	}, 1000);
}

function showTrap(b) {
	//show trap bl ex4
	var delTimer;
	b.sort(function(){ 
		return Math.random() -Math.random()
	});

	trapTimer =setInterval(function(){
		trapBlock =b.last();
		b.pop();
		trapBlock.addClassName("trap");
		delTimer =setTimeout(function(){
			trapBlock.removeClassName("trap");
			b.push(trapBlock);
		}, 2000);
	}, 3000);

}
