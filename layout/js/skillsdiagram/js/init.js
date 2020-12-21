var a = 360;
var b = 360;
var c = 180;
var d = 17;

if (($(window).width() > 979) && ($(window).width() < 1400)) {
	
	var a = 320;
	var b = 320;
	var c = 160;
	var d = 17;
}

if ($(window).width() < 767) {
	
	var a = 280;
	var b = 280;
	var c = 150;
	var d = 15;
	
}

if (($(window).width() > 767) && ($(window).width() < 979)) {
	
	
	var a = 250;
	var b = 250;
	var c = 125;
	var d = 12;
	
}


var o = {
	init: function(){
		this.diagram();
	},
	random: function(l, u){
		return Math.floor((Math.random()*(u-l+1))+l);
	},
	diagram: function(){
		var r = Raphael('diagram', a, b),
			rad = 45,
			defaultText = 'Skills',
			speed = 250;
		
		r.circle(c, c, 55).attr({ stroke: 'none', fill: '#484f5e' });
		
		var title = r.text(c, c, defaultText).attr({
			font: '18px Arial',
			fill: '#fff'
		}).toFront();
		
		r.customAttributes.arc = function(value, color, rad){
			var v = 3.6*value,
				alpha = v == 360 ? 359.99 : v,
				random = o.random(91, 240),
				a = (random-alpha) * Math.PI/180,
				b = random * Math.PI/180,
				sx = c + rad * Math.cos(b),
				sy = c - rad * Math.sin(b),
				x = c + rad * Math.cos(a),
				y = c - rad * Math.sin(a),
				path = [['M', sx, sy], ['A', rad, rad, 0, +(alpha > 180), 1, x, y]];
			return { path: path, stroke: color }
		}
		
		$('.get').find('.arc').each(function(i){
			var t = $(this), 
				color = t.find('.color').val(),
				value = t.find('.percent').val(),
				text = t.find('.text').text();
			
			rad += d;	
			var z = r.path().attr({ arc: [value, color, rad], 'stroke-width': 12 });
			
			z.mouseover(function(){
                this.animate({ 'stroke-width': 20, opacity: .75 }, 1000, 'elastic');
                if(Raphael.type != 'VML') //solves IE problem
				this.toFront();
				title.stop().animate({ opacity: 0 }, speed, '>', function(){
					this.attr({ text: text + '\n' + value + '%' }).animate({ opacity: 1 }, speed, '<');
				});
            }).mouseout(function(){
				this.stop().animate({ 'stroke-width': 12, opacity: 1 }, speed*4, 'elastic');
				title.stop().animate({ opacity: 0 }, speed, '>', function(){
					title.attr({ text: defaultText }).animate({ opacity: 1 }, speed, '<');
				});	
            });
		});
		
	}
}
$(function(){ o.init(); });
