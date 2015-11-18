"use strict"
var stack = [];
window.onload = function () {
    var displayVal = "0";
    var integer ="0";
    var br_stack =[];
    var start_flag =0;
    var dec_flag =0;
    var op_flag =0;

    for (var i in $$('button')) {
        $$('button')[i].onclick = function () {
            if (start_flag ==0) {
                start_flag =1;
                $('expression').innerHTML ="0";
            }

            var value =$(this).innerHTML; 
            if (0 <=value && value <=9) {
                op_flag =0;
                if (displayVal !="0") {
                    displayVal =displayVal +value;
                    integer =integer +value;
                    $('result').innerHTML =integer;
                    if (stack.last() ===")") {
                        stack.push("*");
                    }
                }

                else {
                    displayVal =value;
                    integer =value;
                    $('result').innerHTML =integer;
                    if (stack.last() ===")") {
                        stack.push("*");
                    }
                }
            }

            else if (value ==".") {
                if (!dec_flag) {
                    dec_flag =1;
                    op_flag =0;
                    displayVal =displayVal +value;
                    integer =integer +value;
                    $('result').innerHTML =integer;
                }           
            }

            else if (value =="AC"){
                stack =[];
                br_stack =[];
                start_flag =0;
                dec_flag =0;
                op_flag =0;
                displayVal ="0";
                integer ="";
                $('expression').innerHTML ="0";
                $('result').innerHTML ="0"; 
            }

            else if (value =="(") {
                pushto(stack, integer);

                if (!isNaN(stack.last())) {
                    op_flag =0;
                    br_stack.push("1");                   
                    stack.push("*");
                    stack.push(value);
                    displayVal =displayVal +value;
                    $('expression').innerHTML =displayVal;
                    if (integer != "") {
                        $('result').innerHTML =integer; 
                    }
                    integer ="";
                }

                else {
                    op_flag =0;
                    br_stack.push("1");
                    stack.push(value);
                    displayVal =displayVal +value;
                    $('expression').innerHTML =displayVal;
                    if (integer != "") {
                        $('result').innerHTML =integer; 
                    }
                }         
            }

            else if (value ==")") {
                if (!isValidExpression(br_stack)) {
                    op_flag =0;
                    br_stack.pop();
                    pushto(stack, integer);
                    stack.push(value);
                    displayVal =displayVal +value;
                    $('expression').innerHTML =displayVal;
                    if (integer != "") {
                        $('result').innerHTML =integer; 
                    }
                    integer ="";
                }
            }

            else if (value =="=") {
                pushto(stack, integer);
                alert(stack);
                if (!isValidExpression(br_stack)) {
                    $('expression').innerHTML =displayVal;
                    $('result').innerHTML ="ERROR";
                }

                else if (isNaN(stack.last())) {
                    $('expression').innerHTML =displayVal;
                    $('result').innerHTML ="ERROR";                    
                }

                else {
                    $('expression').innerHTML =displayVal;
                    $('result').innerHTML =postfixCalculate(stack);
                }
            }

            else { //operand
                if (op_flag ==0 || stack.last() =="(") {
                    dec_flag =0;
                    op_flag =1;
                    pushto(stack, integer);
                    stack.push(value);
                    displayVal =displayVal +value;
                    $('expression').innerHTML =displayVal;
                    if (integer != "") {
                        $('result').innerHTML =integer; 
                    }
                    integer ="";
                }
            }    

//            $('result').innerHTML = displayVal;
        }
    }
}

function pushto(s, str) {
    if (str != "") {
        s.push(str);
    }
}

function isValidExpression(s) {
    if (s.length ==0) {
        return true;
    }
    else {
        return false;
    }
}
function infixToPostfix(s) {
    var priority = {
        "+":0,
        "-":0,
        "*":1,
        "/":1
    };
    var tmpStack = [];
    var result = [];
    for(var i =0; i<stack.length ; i++) {
        if(!isNaN(s[i])){
            result.push(s[i]);
        } else {
            if(tmpStack.length === 0){
                tmpStack.push(s[i]);
            } else {
                if(s[i] === ")"){
                    while (true) {
                        if(tmpStack.last() === "("){
                            tmpStack.pop();
                            break;
                        } else {
                            result.push(tmpStack.pop());
                        }
                    }
                    continue;
                }
                if(s[i] ==="(" || tmpStack.last() === "("){
                    tmpStack.push(s[i]);
                } else {
                    while(priority[tmpStack.last()] >= priority[s[i]]){
                        result.push(tmpStack.pop());
                    }
                    tmpStack.push(s[i]);
                }
            }
        }
    }
    for(var i = tmpStack.length; i > 0; i--){
        result.push(tmpStack.pop());
    }
    return result;
}
function postfixCalculate(s) {
    var before =[];
    before =infixToPostfix(s);
    var after =[];
    var result =0;

    for (var i =0; i <before.length; i++) {
        if (!isNaN(before[i])) {
            after.push(parseFloat(before[i]));
        }

        else if (before[i] ==="+") {
            var a =after.pop();
            var b =after.pop();
            var ans =b +a;
            after.push(ans);
        }

        else if (before[i] ==="-") {
            var a =after.pop();
            var b =after.pop();
            var ans =b -a;
            after.push(ans);
        }

        else if (before[i] ==="*") {
            var a =after.pop();
            var b =after.pop();
            var ans =b *a;
            after.push(ans);
        }

        else if (before[i] ==="/") {
            var a =after.pop();
            var b =after.pop();
            var ans =b /a;
            after.push(ans);
        }
    }

    if (after.length ==1) {
        result =after[0]; 
    }

    else {
        $('result').innerHTML ="ERROR";
    }

    return result;
}
