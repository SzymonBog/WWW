// gets current date
function gettheDate()
{
	Todays = new Date();
	TheDate = "" + (Todays.getMonth()+1) +" / "+ Todays.getDate() + " / " + (Todays.getYear()-100);
	document.getElementById("data").innerHTML = TheDate;
}

var timerID = null;
var timerRunning = false;

// stops clock
function stopclock()
{
	if (timerRunning)
		clearTimeout(timerID);
	timerRunning = false;
}

// starts clock
function startclock()
{
	stopclock();
	gettheDate();
	showtime();
}

// shows time and date
function showtime()
{
	var now = new Date();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds = now.getSeconds();
	var timevalue = "" + ((hours >12) ? hours -12 :hours)
	timevalue += ((minutes < 10) ? ":0" : ":") + minutes
	timevalue += ((seconds < 10) ? ":0" : ":") + seconds
	timevalue += (hours >= 12) ? " P.M." : " A.M."
	document.getElementById("zegarek").innerHTML = timevalue;
	timerID = setTimeout("showtime()",1000);
	timerRunning = true;
}
