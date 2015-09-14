function sidebarAdjust(){
	a = document.getElementById("front");
	b = document.getElementById("sidebar");
	c = document.getElementById("navbar");
	d = document.getElementById("footer");
	b.style.height = (a.offsetHeight-c.offsetHeight-d.offsetHeight)+"px";
}
window.addEventListener("resize", sidebarAdjust, false);

