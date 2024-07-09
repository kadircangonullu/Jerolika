/*
* IPAD 
*
*/

var _touchMove = false;

document.addEventListener('touchmove', function($evt)
{
	denyMove = '1';
	_touchMove = true;

}, false);

document.addEventListener('touchstart', function($evt)
{
	if($evt.target.id != 'chatscreen')
	{
		return false;
	}

    	if(_touchMove != true)
	{
		var touch = event.touches[0];

		dest_x = touch.pageX;
		dest_y = touch.pageY;

		denyMove = '0';
		moveImage('_a_');
	}

}, false);

document.addEventListener('touchend', function($evt)
{
	doMoveTimer();
	_touchMove = false;

}, false);