<?php
error_reporting(0);
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
include "../../../config/library.php";

$no_rm=$_GET['no_rm'];
?>

<div class="card">
    <div class="card-header">
        <strong>Ambil Gambar</strong>
    </div>
    <div class="card-block">
        <div class="row">
            
            <div class="col-md-6" id="form_gambar">
                    
                    <form id="tambah_pasien_gambar" class="form"  method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_pasien" value="<?php echo $no_rm;?>" id="id_pasien">
                        

                        <div class="form-group" style="width:900px;">

                            <div id="container" style="float:left;width:350px;">
                                <video autoplay id="videoElement" style="width: 350px; height: 260px; border: solid 1pt #C6CFD6 ; margin-top: 15px;">
                                 
                                </video>
                                <input type="button" class="btn btn-success btn-sm" value="Capture" id="save" />
                            </div>
                            
                                    <canvas id="canvas" height="250px" width="350px" style=" border: solid 1pt #C6CFD6; margin-top: 15px;float:right;">
                                    </canvas>
                                       <!--  <input type="button" onclick="uploadEx()" value="Upload" /> -->
                                        <form method="post" accept-charset="utf-8" name="form1">
                                        <input name="hidden_data" id='hidden_data' type="hidden"/>
                                    </form>

                                    <form>
                                        <div style="height: 25px; width: 600px; overflow: hidden">
                                           <!--  <input type="button" id="btnText" value="Text" onclick="canvasMgr.setMode('text');" />   -->

                                           <!-- <input type="button" id="btnPaint" class="btn btn-success btn-sm" value="Paint" onclick="canvasMgr.setMode('paint');" />
                                            <input type="button" id="btnDropper" class="btn btn-success btn-sm" value="Set Color" onclick="canvasMgr.setMode('dropper');" />-->
                                            <div id="dvSwatch" style="height: 10px; display: inline; border: solid 1pt blue">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </div>
                                    </form>
 
                        </div>

                        <!--  -->
                        
                        <hr>
                        <button type="button"  onclick="uploadEx()" class="btn btn-primary btn-sm" id="btnSimpanGambar">Simpan</button>
                        <button type="button" onClick="closePage()" class="btn btn-danger btn-sm" id="btnClose">Close</button>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php
    pg_close($dbconn);
?>

<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>

<script type="text/javascript">



$(document).ready(function(){
    $(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
   

});

/**/
var canvasMgr;
            function CanvasManager(canvasId) {
                this.canvas = $('#' + canvasId);
                this.imgColor = [255, 255, 255];
                this.buttonDown = false;
                this.lastPos = [0, 0];
                this.mode;

                this.canvas.mouseup(function () {
                    canvasMgr.buttonDown = false;
                });

                this.canvas.mouseout(function () {
                    canvasMgr.buttonDown = false;
                });

                this.canvas.mousedown(function () {
                    if (!canvasMgr.mode)
                        return;

                    if (arguments.length > 0) {
                        var arg = arguments[0];
                        var ctx = canvasMgr.canvas.get(0).getContext("2d");
                        var offsets = getOffsets(arg);

                        if (canvasMgr.mode == 'dropper') {
                            var imgData = ctx.getImageData(offsets.offsetX, offsets.offsetY, 1, 1);

                            canvasMgr.imgColor[0] = imgData.data[0];
                            canvasMgr.imgColor[1] = imgData.data[1];
                            canvasMgr.imgColor[2] = imgData.data[2];

                            $('#dvSwatch').css('background-color', 'rgb(' + imgData.data[0] +
                            ',' + imgData.data[1] +
                            ',' + imgData.data[2] + ')');
                        }
                        else if (canvasMgr.mode == 'paint') {
                            canvasMgr.buttonDown = true;
                        }
                        else if (canvasMgr.mode == 'text') {
                            canvasMgr.lastPos[0] = offsets.offsetX;
                            canvasMgr.lastPos[1] = offsets.offsetY;
                        }
                    }
                });

                this.canvas.mousemove(function (e) {
                    var arg = e;
                    var ctx = canvasMgr.canvas.get(0).getContext("2d");
                    if (canvasMgr.mode == 'paint') {
                        if (canvasMgr.buttonDown) { //mousebutton down

                            var offsets = getOffsets(e);
                            var imgData = ctx.getImageData(offsets.offsetX - 5, offsets.offsetY - 5, 10, 10);

                            for (i = 0; i < imgData.width * imgData.height * 4; i += 4) {
                                imgData.data[i] = canvasMgr.imgColor[0];
                                imgData.data[i + 1] = canvasMgr.imgColor[1];
                                imgData.data[i + 2] = canvasMgr.imgColor[2];
                                imgData.data[i + 3] = 255;
                            }

                            ctx.putImageData(imgData, offsets.offsetX - 5, offsets.offsetY - 5);
                        }
                    }
                });

                $(window).keypress(function (e) {
                    if (canvasMgr.mode == 'text') {
                        var canvasDOM = canvasMgr.canvas.get(0);
                        var ctx = canvasDOM.getContext("2d");
                        ctx.font = "20pt Arial";
                        ctx.textBaseline = "bottom";
                        ctx.textAlign = "left";
                        ctx.fillStyle = 'rgb(' + canvasMgr.imgColor[0] +
                            ',' + canvasMgr.imgColor[1] +
                            ',' + canvasMgr.imgColor[2] + ')';

                        ctx.fillText(String.fromCharCode(e.which), canvasMgr.lastPos[0], canvasMgr.lastPos[1]);
                        var textMTX = ctx.measureText(String.fromCharCode(e.which));
                        canvasMgr.lastPos[0] += textMTX.width + 1;
                    }
                });
            }

            CanvasManager.prototype.setMode = function (mode) {
                this.mode = mode;
                var cur;
                switch (this.mode) {
                    case 'text':
                        cur = 'text';
                        break;
                    case 'dropper':
                        cur = 'pointer'
                        break;
                    case 'paint':
                        cur = 'crosshair';
                        break;
                    default:
                        cur = 'default';
                        break;

                }
                var localCanvas = this.canvas;

                this.canvas.mouseover(function () {
                    localCanvas.css('cursor', cur);
                });
            }

            CanvasManager.prototype.drawImage = function (image, x, y, w, h) {
                var canvas = this.canvas.get(0);
                var ctx = canvas.getContext("2d");
                ctx.drawImage(image, x, y, w, h);
            }

    

            /* ambil gambar dari webcam*/
            var video = document.querySelector("#videoElement");

            // check for getUserMedia support
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
             
            if (navigator.getUserMedia) {      
                // get webcam feed if available
                navigator.getUserMedia({video: true}, handleVideo, videoError);
            }
             
            function handleVideo(stream) {
                // if found attach feed to video element
                
                video.srcObject = stream;
            }
             
            function videoError(e) {
                // no webcam found - do something
                alert("NO CAM");
            }

            var v;
            v = document.getElementById('videoElement');

            function draw(v) {

                if(v.paused || v.ended) return false;

                //context.drawImage(v,0,0,w,h); 
                canvasMgr = new CanvasManager('canvas');

                canvasMgr.drawImage(v, 1, 1, 350, 250);
               
                var uri = canvas.toDataURL("image/png");
               
               
               imgtag.src = uri; 
            }

            document.getElementById('save').addEventListener('click',function(e){
               
                draw(v);
               
            });

            var fr;

            sel.addEventListener('change',function(e){
                var f = sel.files[0];
               
                fr = new FileReader();
                fr.onload = receivedData;

                fr.readAsDataURL(f); // get captured image as data URI
            })
                     
            /**/

            function getOffsets(evt) {
                var offsetX, offsetY;
                if (typeof evt.offsetX != 'undefined') {
                    offsetX = evt.offsetX;
                    offsetY = evt.offsetY;
                }
                else if (typeof evt.layerX != 'undefined') {
                    offsetX = evt.layerX;
                    offsetY = evt.layerY;
                }
                return { 'offsetX': offsetX, 'offsetY': offsetY };
            }

            /*menyimpan foto ke folder*/
            function uploadEx() {

                var canvas = document.getElementById("canvas");
                var dataURL = canvas.toDataURL();
                //document.getElementById('hidden_data').value = dataURL;
                var nilai= $("#tambah_pasien_gambar").serialize();
                var data = nilai+'&imgBase64='+dataURL;
               // alert(nilai);

                $.ajax({
                      type: "POST",
                      url: "aksi-tambah-pasien-gambar",
                      data: data,
                      success: function(result,data) {
                        //alert(result);
                           location.reload(); 
                       },

                    }).done(function(o) {
                      console.log('saved');
                      alert('Berhasil di Upload'); 

                    });

            };
            function closePage()
            {
                //alert(0);
                location.reload();
            }


/**/

</script>

