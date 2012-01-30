jQuery(function($) {
    charts = {
        pieOver: function(){
            this.sector.stop();
            this.sector.scale(1.1, 1.1, this.cx, this.cy);

            if (this.label) {
                this.label[0].stop();
                this.label[0].attr({ r: 7.5 });
                this.label[1].attr({ 'font-weight': 800 });
            }
        },
        pieOut: function(){
            {
                this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, 'bounce');

                if (this.label) {
                    this.label[0].animate({ r: 5 }, 500, 'bounce');
                    this.label[1].attr({ 'font-weight': 400 });
                }
            }
        },
        barOver: function(){
            this.flag = this.paper.popup(this.bar.x, this.bar.y, this.bar.value || "0").insertBefore(this);
        },
        barOut: function(){
            this.flag.animate({opacity: 0}, 300, function () {this.remove();});
        },
        drawLabel: function(paper, left, top, text, font){
            //console.log(paper.width);
            var label = paper.text(left, top, text).attr({font: font});
            if(left=='auto')
                label.attr({x: paper.width/2});
            if(top=='auto')
                label.attr({y: paper.height/2});
        }
    }
})