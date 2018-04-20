(function() {
	"use strict";

	/*
	HELPER FUNCTIONS
	*/
	function clickInsideElement(e, className) {
		var el = e.srcElement || e.target;

		if (el.classList.contains(className)) {
			return el;
		} else {
			while(el = el.parentNode) {
				if (el.classList && el.classList.contains(className)) {
					return el;
				}
			}
		}

		return false;
	}

	function getPosition(e) {
		var posx = 0;
		var posy = 0;

		if (!e) {
			var e = window.event;
		}

		if (e.pageX || e.pageY) {
			posx = e.pageX;
			posy = e.pageY;
		} else if(e.clientX || e.clientY) {
			posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
			posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
		}

		return {
			x: posx,
			y: posy
		}
	}

	/*
	CORE FUNCTIONS
	*/

	/*
	variables
	*/
	// var contextMenuClassName = "context-menu";
	var contextMenuClassName = "context-menu";
	var contextMenuItemClassName = "context-menu_item";
	var contextMenuLinkClassName = "context-menu_link";
	var contextMenuActive = "context-menu--active";

	var taskItemClassName = 'task';
	var taskItemInContext;

	var clickCoords;
	var clickCoordsX;
	var clickCoordsY;

	var menu = document.querySelector("#context-menu");
	var menuItems = menu.querySelectorAll(".context-menu_item");
	var menuState = 0;
	var menuWidth;
	var menuHeight;
	var menuPosition;
	var menuPositionX;
	var menuPositionY;
	var windowWidth;
	var windowHeight;

	function positionMenu(e) {
		clickCoords = getPosition(e);
		clickCoordsX = clickCoords.x;
		clickCoordsY = clickCoords.y;

		menuWidth = menu.offsetWidth + 4;
		menuHeight = menu.offsetHeight + 4;

		windowWidth = window.innerWidth;
		windowHeight = window.innerHeight;

		if ((windowWidth - clickCoordsX) < menuWidth) {
			menu.style.left = windowWidth - menuWidth + "px";
		} else {
			menu.style.left = clickCoordsX + "px";
		}

		if ((windowHeight - clickCoordsY) < menuHeight) {
			menu.style.top = windowHeight - menuHeight + "px";
		} else {
			menu.style.top = clickCoordsY + "px";
		}
	}

	/*
	Initialize our app's code
	*/
	function init() {
		contextListener();
		clickListener();
		keyupListener();
		resizeListener();
	}

	/*
	Listens for context menu events
	*/
	function contextListener() {
		document.addEventListener("contextmenu", function(e) {
			taskItemInContext = clickInsideElement(e, taskItemClassName);

			if (taskItemInContext) {
				e.preventDefault();
				toggleMenuOn();
				positionMenu(e);
			} else {
				taskItemInContext = null;
				toggleMenuOff();
			}
		});
	}

	/*
	Listens for click events
	*/
	function clickListener() {
		document.addEventListener("click", function(e) {
			var clickeElIsLink = clickInsideElement(e, contextMenuLinkClassName);

			if (clickeElIsLink) {
				// e.preventDefault();
				menuItemListener(clickeElIsLink);
			} else {
				var button = e.which || e.button;
				if (button === 1) {
					toggleMenuOff();
				}
			}
		});
	}

	/*
	Listens for keyup events
	*/
	function keyupListener() {
		window.onkeyup = function(e) {
			if (e.keyCode === 27) {
				toggleMenuOff();
			}
		}
	}

	/*
	Listens for screen resize
	*/
	function resizeListener() {
		window.onresize = function(e) {
			toggleMenuOff();
		};
	}

	/*
	Listens for menu items
	*/
	function menuItemListener(link) {
		var id = taskItemInContext.getAttribute("data-id");
		console.log(taskItemInContext);
		var action = link.getAttribute("data-action");

		console.log("Task ID - "+ id +", Task action - " + action);
		toggleMenuOff();


	}

	/*
	Turns the custom context menu on
	*/
	function toggleMenuOn() {
		if (menuState !== 1) {
			menuState = 1;
			menu.classList.add(contextMenuActive);
		}
	}

	/*
	Turns the custom context menu off
	*/
	function toggleMenuOff() {
		if (menuState !== 0) {
			menuState = 0;
			menu.classList.remove(contextMenuActive);
		}
	}

	// RUN the app
	init();

})();
