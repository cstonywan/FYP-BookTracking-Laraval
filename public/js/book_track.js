
function trackTableChangeColor(t,id) {       
    window.location='/b/track/'+id; 
    $('#trackTable').find('tr').each(function() {
        // var row = this;
        this.style.backgroundColor = 'white';
    });    
    t.style.backgroundColor = '#F9CFCF';    
}



function load() {
    
    var ab_distance = width;
    var bc_distance = height;
    var cd_distance = width;
    var ad_distance = height;

    if(records != null){
        var a_distance = records[0].radius;
        var b_distance = records[1].radius;
        var c_distance = records[2].radius;
        var d_distance = records[3].radius;
    }
    var scale = 200;
    var reader_width = 100;
    var reader_height = 50;

    var reader_a = document.getElementById("reader_a");
    var reader_b = document.getElementById("reader_b");
    var reader_c = document.getElementById("reader_c");
    var reader_d = document.getElementById("reader_d");
    var circle_a = document.getElementById("circle_a");
    var circle_b = document.getElementById("circle_b");
    var circle_c = document.getElementById("circle_c");
    var circle_d = document.getElementById("circle_d");
    var line_ab = document.getElementById("line_ab");
    var line_bc = document.getElementById("line_bc");
    var line_cd = document.getElementById("line_cd");
    var line_ad = document.getElementById("line_ad");
    var label_ab = document.getElementById("label_ab");
    var label_bc = document.getElementById("label_bc");
    var label_cd = document.getElementById("label_cd");
    var label_ad = document.getElementById("label_ad");

    var ax = parseInt(reader_a.getAttribute("x"));
    var ay = parseInt(reader_a.getAttribute("y"));
    var aw = parseInt(reader_a.getAttribute("width"));
    var bx = ax + reader_width + ab_distance * scale;
    var by = ay;
    var cx = bx;
    var cy = by + reader_height + bc_distance * scale;
    var dx = ax;
    var dy = cy;

    var acx = ax + reader_width / 2;
    var acy = ay + reader_height / 2;
    var bcx = bx + reader_width / 2;
    var bcy = by + reader_height / 2;
    var ccx = cx + reader_width / 2;
    var ccy = cy + reader_height / 2;
    var dcx = dx + reader_width / 2;
    var dcy = dy + reader_height / 2;

    var lab_x1 = ax + reader_width;
    var lab_y1 = acy;
    var lab_x2 = bx;
    var lab_y2 = bcy;
    var lbc_x1 = bcx;
    var lbc_y1 = by + reader_height;
    var lbc_x2 = ccx;
    var lbc_y2 = cy;
    var lcd_x1 = dx + reader_width;
    var lcd_y1 = dcy;
    var lcd_x2 = cx;
    var lcd_y2 = ccy;
    var lad_x1 = acx;
    var lad_y1 = ay + reader_height;
    var lad_x2 = dcx;
    var lad_y2 = dy;

    var mab_x = (lab_x1 + lab_x2) / 2;   
    var mab_y = ay;
    var mbc_x = bx + reader_width;
    var mbc_y = (lbc_y1 + lbc_y2) / 2;
    var mcd_x = (lcd_x1 + lcd_x2) / 2;
    var mcd_y = cy + reader_height;
    var mad_x = ax;
    var mad_y = (lad_y1 + lad_y2) / 2;

    // reader_d.setAttribute("transform", "translate(" + bx + + "," + by + ")")

    reader_b.setAttribute("x", bx);
    reader_b.setAttribute("y", by);
    reader_c.setAttribute("x", cx);
    reader_c.setAttribute("y", cy);
    reader_d.setAttribute("x", dx);
    reader_d.setAttribute("y", dy);

    if(records != null){
        circle_a.setAttribute("cx", acx);
        circle_a.setAttribute("cy", acy);
        circle_a.setAttribute("r", a_distance * scale);
        circle_b.setAttribute("cx", bcx);
        circle_b.setAttribute("cy", bcy);
        circle_b.setAttribute("r", b_distance * scale);
        circle_c.setAttribute("cx", ccx);
        circle_c.setAttribute("cy", ccy);
        circle_c.setAttribute("r", c_distance * scale);
        circle_d.setAttribute("cx", dcx);
        circle_d.setAttribute("cy", dcy);
        circle_d.setAttribute("r", d_distance * scale);
    }
    line_ab.setAttribute("x1", lab_x1);
    line_ab.setAttribute("y1", lab_y1);
    line_ab.setAttribute("x2", lab_x2);
    line_ab.setAttribute("y2", lab_y2);
    line_bc.setAttribute("x1", lbc_x1);
    line_bc.setAttribute("y1", lbc_y1);
    line_bc.setAttribute("x2", lbc_x2);
    line_bc.setAttribute("y2", lbc_y2);
    line_cd.setAttribute("x1", lcd_x1);
    line_cd.setAttribute("y1", lcd_y1);
    line_cd.setAttribute("x2", lcd_x2);
    line_cd.setAttribute("y2", lcd_y2);
    line_ad.setAttribute("x1", lad_x1);
    line_ad.setAttribute("y1", lad_y1);
    line_ad.setAttribute("x2", lad_x2);
    line_ad.setAttribute("y2", lad_y2);

    label_ab.setAttribute("x", mab_x);
    label_ab.setAttribute("y", mab_y);
    label_ab.firstChild.data = ab_distance + " m";

    label_bc.setAttribute("x", mbc_x);
    label_bc.setAttribute("y", mbc_y);
    label_bc.firstChild.data = bc_distance + " m";

    label_cd.setAttribute("x", mcd_x);
    label_cd.setAttribute("y", mcd_y);
    label_cd.firstChild.data = cd_distance + " m";

    label_ad.setAttribute("x", mad_x);
    label_ad.setAttribute("y", mad_y);
    label_ad.firstChild.data = ad_distance + " m";

    var spinner = document.getElementById("spinner");
    spinner.style.display = 'none';
    var div_svg = document.getElementById("div_svg");
    div_svg.style.display = 'block';
}
