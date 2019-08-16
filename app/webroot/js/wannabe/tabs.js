/*-----------------------------------------------------------
    Toggles element's display value
    Input: any number of element id's
    Output: none 
    ---------------------------------------------------------*/
function toggleDisp() {
    for (var i=0;i<arguments.length;i++){
        var d = document.getElementById(arguments[i]);
        if (d.style.display == 'none') {
            d.style.display = 'block';
        } else {
            d.style.display = 'none';
	}
    }
}
/*-----------------------------------------------------------
    Toggles tabs - Closes any open tabs, and then opens current tab
    Input:     1.The number of the current tab
                    2.The number of tabs
                    3.(optional)The number of the tab to leave open
                    4.(optional)Pass in true or false whether or not to animate the open/close of the tabs
    Output: none 
    ---------------------------------------------------------*/
function toggleTab(num,numelems,opennum,animate) {
    if (document.getElementById('tabContent'+num).style.display == 'none'){
        for (var i=1;i<=numelems;i++){
            if ((opennum == null) || (opennum != i)){
                var temph = 'tabHeader'+i;
                var h = document.getElementById(temph);
                if (!h){
                    var h = document.getElementById('tabHeaderActive');
                    h.id = temph
	            h.style.borderTop = '2px solid #fff';
            	    h.style.borderRight = '2px solid #fff';
            	    h.style.borderLeft = '2px solid #fff';
                }
                var tempc = 'tabContent'+i;
                var c = document.getElementById(tempc);
                if(c.style.display != 'none'){
                    if (animate || typeof animate == 'undefined')
                        Effect.toggle(tempc,'blind',{duration:0.5, queue:{scope:'menus', limit: 3}});
                    else
                        toggleDisp(tempc);
                }
            }
        }
        var h = document.getElementById('tabHeader'+num);
        if (h)
            h.id = 'tabHeaderActive';
	    h.style.borderTop = '2px solid #555';
            h.style.borderRight = '2px solid #555';
            h.style.borderLeft = '2px solid #555';
        h.blur();
        var c = document.getElementById('tabContent'+num);
        c.style.marginTop = '2px';
        if (animate || typeof animate == 'undefined'){
            Effect.toggle('tabContent'+num,'blind',{duration:0.5, queue:{scope:'menus', position:'end', limit: 3}});
        }else{
            toggleDisp('tabContent'+num);
        }
    }
}
