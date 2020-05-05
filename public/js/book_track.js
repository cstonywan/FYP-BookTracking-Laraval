var canvas = document.getElementById("can");

function trackTableChangeColor(t) {
    $('#trackTable').find('tr').each(function() {
        // var row = this;
        this.style.backgroundColor = 'white';
    });
    t.style.backgroundColor = '#F9CFCF';
}

function rgbToHex(r, g, b) {
    if (r > 255 || g > 255 || b > 255)
        throw "Invalid color component";
    return ((r << 16) | (g << 8) | b).toString(16);
}

function getColor(canvas, x, y) {
  var ctx = canvas.getContext("2d");
  var data = ctx.getImageData(x, y, 1, 1).data;
  var result = document.getElementById("color");
  result.innerHTML = 'R:' + data[0] + ' G:' + data[1] + ' B:' + data[2] + ' A:' + data[3];
  // alert('R:' + data[0] + ' G:' + data[1] + ' B:' + data[2] + ' A:' + data[3]);
}

function findColor() {
    var x = document.getElementById("value_x").value;
    var y = document.getElementById("value_y").value;
    getColor(window.canvas, x, y)
}

function getResult(canvas, x, y) {
    var ctx = canvas.getContext("2d");
    var data = ctx.getImageData(x, y, 2, 2).data;
    return data[3];
}

function draw() {
    // alert(records[0]['radius']);
    var width = widthData;
    var height = heightData;

    // ED
    // var a_distance = 0.3; //radius
    // var b_distance = 0.56;
    // var c_distance = 0.56;
    // var d_distance = 0.73;
    var radius = [
        records[0]['radius'],
        records[1]['radius'],
        records[2]['radius'],
        records[3]['radius'],          
    ];
    // for(var i = 0; i < records.length ;i++){
    //     radius[i]=records[i]['radius'];
    // }

    // 74
    // var a_distance = 0.66;
    // var b_distance = 0.3;
    // var c_distance = 0.85;
    // var d_distance = 0.56;
    // //1F
    // var a_distance = 0.48;
    // var b_distance = 0.48;
    // var c_distance = 0.48;
    // var d_distance = 0.48;
    // // 1473
    // var a_distance = 0.66;
    // var b_distance = 0.76;
    // var c_distance = 0.25;
    // var d_distance = 0.64;
    // // 6DB
    // var a_distance = 0.73;
    // var b_distance = 0.53;
    // var c_distance = 0.54;
    // var d_distance = 0.22;

    // var scale = 300;
    var scale = 420 / (width * 2);

    var svg_data = document.getElementById("svg_data");
    var canvas = document.getElementById("can");
    var background_pattern = document.getElementById("background_pattern");
    var pattern_rect = document.getElementById("pattern_rect");
    svg_width = width * 2 * scale;
    svg_height = height * 2 * scale;
    pattern_width = width / 2 * scale;
    pattern_height = height / 2 * scale;
    svg_data.setAttribute("width", svg_width + "px");
    svg_data.setAttribute("height", svg_height + "px");
    canvas.setAttribute("width", svg_width + "px");
    canvas.setAttribute("height", svg_height + "px");
    background_pattern.setAttribute("width", pattern_width);
    background_pattern.setAttribute("height", pattern_height);
    pattern_rect.setAttribute("width", pattern_width);
    pattern_rect.setAttribute("height", pattern_height);

    var target_area = document.getElementById("target_area");
    target_area.setAttribute("width", pattern_width);
    target_area.setAttribute("height", pattern_height);

    var reader_a = document.getElementById("reader_a");
    var reader_b = document.getElementById("reader_b");
    var reader_c = document.getElementById("reader_c");
    var reader_d = document.getElementById("reader_d");
    var circle_a = document.getElementById("circle_a");
    var circle_b = document.getElementById("circle_b");
    var circle_c = document.getElementById("circle_c");
    var circle_d = document.getElementById("circle_d");

    var acx = width / 2 * scale;
    var acy = height / 2 * scale;
    var bcx = acx + width * scale;
    var bcy = acy;
    var ccx = acx;
    var ccy = acy + height * scale;
    var dcx = bcx;
    var dcy = ccy;

    reader_a.setAttribute("cx", acx);
    reader_a.setAttribute("cy", acy);
    reader_b.setAttribute("cx", bcx);
    reader_b.setAttribute("cy", bcy);
    reader_c.setAttribute("cx", ccx);
    reader_c.setAttribute("cy", ccy);
    reader_d.setAttribute("cx", dcx);
    reader_d.setAttribute("cy", dcy);

    circle_a.setAttribute("cx", acx);
    circle_a.setAttribute("cy", acy);
    circle_a.setAttribute("r", radius[0] * scale);
    circle_b.setAttribute("cx", bcx);
    circle_b.setAttribute("cy", bcy);
    circle_b.setAttribute("r", radius[1] * scale);
    circle_c.setAttribute("cx", ccx);
    circle_c.setAttribute("cy", ccy);
    circle_c.setAttribute("r", radius[2] * scale);
    circle_d.setAttribute("cx", dcx);
    circle_d.setAttribute("cy", dcy);
    circle_d.setAttribute("r", radius[3] * scale);

    // var div_svg = document.getElementById("div_svg");
    // div_svg.style.display = 'block';
    // can.style.display = "none";

    let xml = new XMLSerializer().serializeToString(svg_data);   // get svg data
    let svg64 = btoa(xml);                         // make it base64
    let b64Start = 'data:image/svg+xml;base64,';
    let image64 = b64Start + svg64;                // prepend a "header"

    circImg.src = image64;                         // image source
    circImg.onload = x=> {
        canvas.getContext('2d').drawImage(circImg, 0, 0); // draw
        window.canvas = canvas;
        var divide1 = svg_width / 4;
        var divide2 = svg_width / 2;
        var divide3 = svg_width / 4 * 3;
        // for (var i=0; i<svg_width; i++) {
        //     for (var j=0; j<svg_height; j++) {
        //         if (i >= divide2 && i < divide3 && j >= divide2 && j < divide3 ) {
        //             c3 = countResult(canvas, i, j);
        //         }
        //     }
        // }
        var a1 = countResult(canvas, 0, divide1, 0, divide1);
        var a2 = countResult(canvas, divide1, divide2, 0, divide1);
        var a3 = countResult(canvas, divide2, divide3, 0, divide1);
        var a4 = countResult(canvas, divide3, svg_width, 0, divide1);
        var b1 = countResult(canvas, 0, divide1, divide1, divide2);
        var b2 = countResult(canvas, divide1, divide2, divide1, divide2);
        var b3 = countResult(canvas, divide2, divide3, divide1, divide2);
        var b4 = countResult(canvas, divide3, svg_width, divide1, divide2);
        var c1 = countResult(canvas, 0, divide1, divide2, divide3);
        var c2 = countResult(canvas, divide1, divide2, divide2, divide3);
        var c3 = countResult(canvas, divide2, divide3, divide2, divide3);
        var c4 = countResult(canvas, divide3, svg_width, divide2, divide3);
        var d1 = countResult(canvas, 0, divide1, divide3, svg_height);
        var d2 = countResult(canvas, divide1, divide2, divide3, svg_height);
        var d3 = countResult(canvas, divide2, divide3, divide3, svg_height);
        var d4 = countResult(canvas, divide3, svg_width, divide3, svg_height);
        var result = [];
        result.push(a1, a2, a3, a4);
        result.push(b1, b2, b3, b4);
        result.push(c1, c2, c3, c4);
        result.push(d1, d2, d3, d4);

        // getColor(canvas, 0, 0);

        var max_count = 0;
        var max_index;
        for (var i=0; i<16; i++) {
            if (result[i][3] > max_count) {
                max_count = result[i][3];
                max_index = i;
            }
        }
        if (max_count == 0) {
            for (var i=0; i<16; i++) {
                if (result[i][2] > max_count) {
                    max_count = result[i][2];
                    max_index = i;
                }
            }
        }
        // if (max_count == 0) {
        //     for (var i=0; i<16; i++) {
        //         if (result[i][1] > max_count) {
        //             max_count = result[i][1];
        //             max_index = i;
        //         }
        //     }
        // }
        var area_result = index_to_area(max_index);
        var raw_data = document.getElementById("raw_data");
        var result = document.getElementById("result");
        var area = document.getElementById("area");
        raw_data.innerHTML = "Raw Data: [readerA:" + radius[0] + "m, readerB:" + radius[1]+ "m, readerC:" + radius[2]+ "m, readerD:" + radius[3] + "m]";
        result.innerHTML = 'count=' + max_count + ', index=' + max_index;
        area.innerHTML = 'The book is in area ' + area_result;

        var target_x = parseInt(max_index % 4) * pattern_width;
        var target_y = parseInt(max_index / 4) * pattern_height;
        var label_target = document.getElementById("label_target");
        target_area.setAttribute("x", target_x);
        target_area.setAttribute("y", target_y);
        label_target.setAttribute("x", target_x + pattern_width / 2);
        label_target.setAttribute("y", target_y + pattern_height / 2);
        label_target.firstChild.data = area_result;

        var spinner = document.getElementById("spinner");
        spinner.style.display = 'none';
        // var display_svg = document.getElementById("display_svg");
        // display_svg.style.display = 'block';

        var show_svg = document.getElementById("show_svg");
        let show_xml = new XMLSerializer().serializeToString(show_svg);   // get svg data
        let show_svg64 = btoa(show_xml);                         // make it base64
        let show_b64Start = 'data:image/svg+xml;base64,';
        let show_image64 = show_b64Start + show_svg64;                // prepend a "header"
        display_img.src = show_image64;

        // var xhr = new XMLHttpRequest();
        // xhr.open("POST", "/api/b/image", true);
        // xhr.setRequestHeader('Content-Type', 'application/json');
        // xhr.send(JSON.stringify({
        //     value: show_image64,
        // }));
        // location.replace("/api/b/image?image=" + show_image64);
    }

    // Draw display svg for user
    var display_svg = document.getElementById("display_svg");
    var show_svg = document.getElementById("show_svg");
    var show_background_pattern = document.getElementById("show_background_pattern");
    var show_pattern_rect = document.getElementById("show_pattern_rect");

    show_svg.setAttribute("width", svg_width);
    show_svg.setAttribute("height", svg_height);
    show_background_pattern.setAttribute("width", pattern_width);
    show_background_pattern.setAttribute("height", pattern_height);
    show_pattern_rect.setAttribute("width", pattern_width);
    show_pattern_rect.setAttribute("height", pattern_height);

    var show_reader_a = document.getElementById("show_reader_a");
    var show_reader_b = document.getElementById("show_reader_b");
    var show_reader_c = document.getElementById("show_reader_c");
    var show_reader_d = document.getElementById("show_reader_d");

    show_reader_a.setAttribute("x", acx - 20);
    show_reader_a.setAttribute("y", acy - 20);
    show_reader_b.setAttribute("x", bcx - 20);
    show_reader_b.setAttribute("y", bcy - 20);
    show_reader_c.setAttribute("x", ccx - 20);
    show_reader_c.setAttribute("y", ccy - 20);
    show_reader_d.setAttribute("x", dcx - 20);
    show_reader_d.setAttribute("y", dcy - 20);

    var label_reader_a = document.getElementById("label_reader_a");
    var label_reader_b = document.getElementById("label_reader_b");
    var label_reader_c = document.getElementById("label_reader_c");
    var label_reader_d = document.getElementById("label_reader_d");

    label_reader_a.setAttribute("x", acx);
    label_reader_a.setAttribute("y", acy);
    label_reader_b.setAttribute("x", bcx);
    label_reader_b.setAttribute("y", bcy);
    label_reader_c.setAttribute("x", ccx);
    label_reader_c.setAttribute("y", ccy);
    label_reader_d.setAttribute("x", dcx);
    label_reader_d.setAttribute("y", dcy);


    // var show_circle_a = document.getElementById("show_circle_a");
    // var show_circle_b = document.getElementById("show_circle_b");
    // var show_circle_c = document.getElementById("show_circle_c");
    // var show_circle_d = document.getElementById("show_circle_d");
    //
    // show_circle_a.setAttribute("cx", acx);
    // show_circle_a.setAttribute("cy", acy);
    // show_circle_a.setAttribute("r", a_distance * scale);
    // show_circle_b.setAttribute("cx", bcx);
    // show_circle_b.setAttribute("cy", bcy);
    // show_circle_b.setAttribute("r", b_distance * scale);
    // show_circle_c.setAttribute("cx", ccx);
    // show_circle_c.setAttribute("cy", ccy);
    // show_circle_c.setAttribute("r", c_distance * scale);
    // show_circle_d.setAttribute("cx", dcx);
    // show_circle_d.setAttribute("cy", dcy);
    // show_circle_d.setAttribute("r", d_distance * scale);

    var label_a = document.getElementById("label_a");
    var label_b = document.getElementById("label_b");
    var label_c = document.getElementById("label_c");
    var label_d = document.getElementById("label_d");

    var area_width = svg_width / 4;
    var area_x = area_width / 2;
    var area_height = svg_height / 4;
    var area_y = area_height / 2;
    label_1.setAttribute("x", area_x);
    label_2.setAttribute("x", area_x + area_width);
    label_3.setAttribute("x", area_x + area_width * 2);
    label_4.setAttribute("x", area_x + area_width * 3);
    label_a.setAttribute("y", area_y);
    label_b.setAttribute("y", area_y + area_height);
    label_c.setAttribute("y", area_y + area_height * 2);
    label_d.setAttribute("y", area_y + area_height * 3);

    var line_width = document.getElementById("line_width");
    var line_height = document.getElementById("line_height");
    var arrow_up = document.getElementById("arrow_up");
    var arrow_down = document.getElementById("arrow_down");
    var label_width = document.getElementById("label_width");
    var label_height = document.getElementById("label_height");
    var width_line_y = area_height * 3 + area_y;
    var height_line_x = area_width * 3 + area_x;
    line_width.setAttribute("x1", area_width);
    line_width.setAttribute("x2", area_width * 3);
    line_width.setAttribute("y1", width_line_y);
    line_width.setAttribute("y2", width_line_y);
    line_height.setAttribute("x1", height_line_x);
    line_height.setAttribute("x2", height_line_x);
    line_height.setAttribute("y1", area_height);
    line_height.setAttribute("y2", area_height * 3);
    var up_x = height_line_x - 5;
    var up_y = area_height - 5;
    var down_x = height_line_x - 5;
    var down_y = area_height * 3 - 5;
    var left_x = area_width - 5;
    var left_y = width_line_y - 5;
    var right_x = area_width * 3 - 5;
    var right_y = width_line_y - 5;
    arrow_up.setAttribute("transform", "translate(" + up_x + "," + up_y + ")");
    arrow_down.setAttribute("transform", "translate(" + down_x + "," + down_y + ")");
    arrow_left.setAttribute("transform", "translate(" + left_x + "," + left_y + ")");
    arrow_right.setAttribute("transform", "translate(" + right_x + "," + right_y + ")");
    label_width.setAttribute("x", svg_width / 2);
    label_width.setAttribute("y", left_y + 20);
    label_width.firstChild.data = width + " m";
    label_height.setAttribute("x", up_x + 30);
    label_height.setAttribute("y", svg_height / 2);
    label_height.firstChild.data = height + " m";
}

function countResult(canvas, i1, i2, j1, j2) {
    var array = [0, 0, 0, 0];
    for (var i=i1; i<i2; i++) {
        for (var j=j1; j<j2; j++) {
            switch(getResult(canvas, i, j)) {
                case 128:
                  array[0]++;
                  break;
                case 192:
                  array[1]++;
                  break;
                case 224:
                  array[2]++;
                  break;
                case 240:
                  array[3]++;
                  break;
            }
        }
    }
    return array;
}

function index_to_area(index) {
    var area;
    var alpha = parseInt(index / 4);
    var num = index % 4 + 1;
    switch (alpha) {
      case 0:
        area = "A" + num;
        break;
      case 1:
        area = "B" + num;
        break;
      case 2:
        area = "C" + num;
        break;
      case 3:
        area = "D" + num;
        break;
    }
    return area;
}

function onedraw(){
    //alert(records[0]['radius']);
    var width = widthData;
    var height = heightData;

    // ED
    // var a_distance = 0.3; //radius
    // var b_distance = 0.56;
    // var c_distance = 0.56;
    // var d_distance = 0.73;
    var radius = [
        RadiusofLinearRegressionValueA,      
        RadiusofLinearRegressionValueB,
        RadiusofLinearRegressionValueC,
        RadiusofLinearRegressionValueD 
    ];
    // for(var i = 0; i < records.length ;i++){
    //     radius[i]=records[i]['radius'];
    // }

    // 74
    // var a_distance = 0.66;
    // var b_distance = 0.3;
    // var c_distance = 0.85;
    // var d_distance = 0.56;
    // //1F
    // var a_distance = 0.48;
    // var b_distance = 0.48;
    // var c_distance = 0.48;
    // var d_distance = 0.48;
    // // 1473
    // var a_distance = 0.66;
    // var b_distance = 0.76;
    // var c_distance = 0.25;
    // var d_distance = 0.64;
    // // 6DB
    // var a_distance = 0.73;
    // var b_distance = 0.53;
    // var c_distance = 0.54;
    // var d_distance = 0.22;

    // var scale = 300;
    var scale = 300 / (width * 2);

    var svg_data = document.getElementById("svg_data");
    var canvas = document.getElementById("can");
    var background_pattern = document.getElementById("background_pattern");
    var pattern_rect = document.getElementById("pattern_rect");
    svg_width = width * 2 * scale;
    svg_height = height * 2 * scale;
    pattern_width = width / 2 * scale;
    pattern_height = height / 2 * scale;
    svg_data.setAttribute("width", svg_width + "px");
    svg_data.setAttribute("height", svg_height + "px");
    canvas.setAttribute("width", svg_width + "px");
    canvas.setAttribute("height", svg_height + "px");
    background_pattern.setAttribute("width", pattern_width);
    background_pattern.setAttribute("height", pattern_height);
    pattern_rect.setAttribute("width", pattern_width);
    pattern_rect.setAttribute("height", pattern_height);



    var reader_a = document.getElementById("reader_a");
    var reader_b = document.getElementById("reader_b");
    var reader_c = document.getElementById("reader_c");
    var reader_d = document.getElementById("reader_d");
    var circle_a = document.getElementById("circle_a");
    var circle_b = document.getElementById("circle_b");
    var circle_c = document.getElementById("circle_c");
    var circle_d = document.getElementById("circle_d");

    var acx = width / 2 * scale;
    var acy = height / 2 * scale;
    var bcx = acx + width * scale;
    var bcy = acy;
    var ccx = acx;
    var ccy = acy + height * scale;
    var dcx = bcx;
    var dcy = ccy;

    reader_a.setAttribute("cx", acx);
    reader_a.setAttribute("cy", acy);
    reader_b.setAttribute("cx", bcx);
    reader_b.setAttribute("cy", bcy);
    reader_c.setAttribute("cx", ccx);
    reader_c.setAttribute("cy", ccy);
    reader_d.setAttribute("cx", dcx);
    reader_d.setAttribute("cy", dcy);

    circle_a.setAttribute("cx", acx);
    circle_a.setAttribute("cy", acy);
    circle_a.setAttribute("r", radius[0] * scale);
    circle_b.setAttribute("cx", bcx);
    circle_b.setAttribute("cy", bcy);
    circle_b.setAttribute("r", radius[1] * scale);
    circle_c.setAttribute("cx", ccx);
    circle_c.setAttribute("cy", ccy);
    circle_c.setAttribute("r", radius[2] * scale);
    circle_d.setAttribute("cx", dcx);
    circle_d.setAttribute("cy", dcy);
    circle_d.setAttribute("r", radius[3] * scale);

    // var div_svg = document.getElementById("div_svg");
    // div_svg.style.display = 'block';
    // can.style.display = "none";

    let xml = new XMLSerializer().serializeToString(svg_data);   // get svg data
    let svg64 = btoa(xml);                         // make it base64
    let b64Start = 'data:image/svg+xml;base64,';
    let image64 = b64Start + svg64;                // prepend a "header"

    circImg.src = image64;                         // image source
    circImg.onload = x=> {
        canvas.getContext('2d').drawImage(circImg, 0, 0); // draw
        window.canvas = canvas;
        var divide1 = svg_width / 4;
        var divide2 = svg_width / 2;
        var divide3 = svg_width / 4 * 3;
        // for (var i=0; i<svg_width; i++) {
        //     for (var j=0; j<svg_height; j++) {
        //         if (i >= divide2 && i < divide3 && j >= divide2 && j < divide3 ) {
        //             c3 = countResult(canvas, i, j);
        //         }
        //     }
        // }
        var a1 = countResult(canvas, 0, divide1, 0, divide1);
        var a2 = countResult(canvas, divide1, divide2, 0, divide1);
        var a3 = countResult(canvas, divide2, divide3, 0, divide1);
        var a4 = countResult(canvas, divide3, svg_width, 0, divide1);
        var b1 = countResult(canvas, 0, divide1, divide1, divide2);
        var b2 = countResult(canvas, divide1, divide2, divide1, divide2);
        var b3 = countResult(canvas, divide2, divide3, divide1, divide2);
        var b4 = countResult(canvas, divide3, svg_width, divide1, divide2);
        var c1 = countResult(canvas, 0, divide1, divide2, divide3);
        var c2 = countResult(canvas, divide1, divide2, divide2, divide3);
        var c3 = countResult(canvas, divide2, divide3, divide2, divide3);
        var c4 = countResult(canvas, divide3, svg_width, divide2, divide3);
        var d1 = countResult(canvas, 0, divide1, divide3, svg_height);
        var d2 = countResult(canvas, divide1, divide2, divide3, svg_height);
        var d3 = countResult(canvas, divide2, divide3, divide3, svg_height);
        var d4 = countResult(canvas, divide3, svg_width, divide3, svg_height);
        var result = [];
        result.push(a1, a2, a3, a4);
        result.push(b1, b2, b3, b4);
        result.push(c1, c2, c3, c4);
        result.push(d1, d2, d3, d4);

        // getColor(canvas, 0, 0);

        var max_count = 0;
        var max_index;
        for (var i=0; i<16; i++) {
            if (result[i][3] > max_count) {
                max_count = result[i][3];
                max_index = i;
            }
        }
        if (max_count == 0) {
            for (var i=0; i<16; i++) {
                if (result[i][2] > max_count) {
                    max_count = result[i][2];
                    max_index = i;
                }
            }
        }
        // if (max_count == 0) {
        //     for (var i=0; i<16; i++) {
        //         if (result[i][1] > max_count) {
        //             max_count = result[i][1];
        //             max_index = i;
        //         }
        //     }
        // }
        var area_result = index_to_area(max_index);
        var raw_data = document.getElementById("raw_data");
        var result = document.getElementById("result");
        var area = document.getElementById("area");
        raw_data.innerHTML = "Raw Data: [readerA:" + radius[0] + "m, readerB:" + radius[1]+ "m, readerC:" + radius[2]+ "m, readerD:" + radius[3] + "m]";
        result.innerHTML = 'count=' + max_count + ', index=' + max_index;
        area.innerHTML = 'The book is in area ' + area_result;

        var target_x = parseInt(max_index % 4) * pattern_width;
        var target_y = parseInt(max_index / 4) * pattern_height;
       
      
      

        var spinner = document.getElementById("spinner");
        spinner.style.display = 'none';
        
    }

   
}