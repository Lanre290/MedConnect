<div id="mydiv" class = "placcard">
  <div id="mydivheader">Progress tracker</div>
  <div class="floating_div_text flex-row align-center" id = "floating_div_text">
    <!-- AI response here-->
  </div>
</div>

<style>
	#mydiv {
            position: absolute;
            z-index: 9;
            background-color: #fafafa;
            border: 1px solid #d3d3d3;
            text-align: center;
            height: fit-content;
            width: fit-content;
            position: fixed;
            bottom: 20px;
            right: 16px;
        }

        #mydivheader {
            padding: 10px;
            cursor: move;
            z-index: 10;
            background-color: var(--primary-color);
            color: #fff;
        }
        .floating_div_text{
            min-height: 200px;
            min-width: 250px;
            max-width: 500px;
            max-height: 500px;
            padding: 10px;
            overflow-y: auto;
        }
</style>

<script>
	// Make the DIV element draggable:
    dragElement(document.getElementById("mydiv"));

    function dragElement(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (document.getElementById(elmnt.id + "header")) {
        // if present, the header is where you move the DIV from:
        document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
        // stop moving when mouse button is released:
        document.onmouseup = null;
        document.onmousemove = null;
    }
    }
</script>