    <style>
        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            flex-direction: row;
        }

        .hero>div {
            margin: 8px;
            border: 3px solid purple;
            border-radius: 10px;
        }

        .columna {
            padding: 1em;
        }

        .qr-container {
            padding: .1em;
        }

        .qr-container img {
            width: 180px;
            height: 180px;
        }
        <?php if($suscripcion['EditarQR']=='NO'):?>
            .contEDIT{
                color: transparent;
                pointer-events: none;
                cursor: default;
            }
        <?php endif;?>    
    </style>
<div class="contEDIT">
<?php if($suscripcion['EditarQR']=='NO'):?>
    <h4 style="color:tomato">Por favor Compra una Membresia 🎁</h4>
        <?php endif;?>    
    <div class="hero">
        <div class="columna">
            <div>
                <input id="qr-text" type="hidden" value="Hello world lorem Hello world lorem Hello world lorem ">
                <input id="qr-size" type="hidden" value="300">
                <div class="form-group">
                    <div class="col label">Color (foreground)</div>
                    <div class="col">
                        <input id="qr-fg" type="color" value="#000000">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col label">Color (background)</div>
                    <div class="col">
                        <input id="qr-bg" type="color" value="#ffffff">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col label">Error correction</div>
                    <div class="col">
                        <select id="qr-ec">
                            <option value="L">Low</option>
                            <option value="M" selected="">Medium</option>
                            <option value="Q">Quartile</option>
                            <option value="H">High</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="qr-container">
            <h4 style="text-align:center ">Vista previa</h4>
            <img id="qr-img" src="https://quickchart.io/qr?text=Hello world&amp;size=200">
            <p>
                <input id="qr-href" type="hidden" name="valorqratributos" value="&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120">
            </p>
        </div>
    </div>
</div>
    </script>
    <script type="text/javascript">
        var qrText = document.getElementById('qr-text');
        var qrSize = document.getElementById('qr-size');
        var qrEc = document.getElementById('qr-ec');
        var qrFg = document.getElementById('qr-fg');
        var qrBg = document.getElementById('qr-bg');

        var qrImage = document.getElementById('qr-img');
        var qrHref = document.getElementById('qr-href');

        function updateQr() {
            if (!qrText.value) {
                return;
            }
            var url = '';

            if (qrBg.value != '#ffffff') {
                url += '&light=' + qrBg.value.slice(1);
            }
            if (qrFg.value != '#000000') {
                url += '&dark=' + qrFg.value.slice(1);
            }
            if (qrEc.value != 'M') {
                url += '&ecLevel=' + qrEc.value;
            }
            if (qrSize.value != 4) {
                url += '&size=' + qrSize.value;
            }

            qrImage.src = "https://quickchart.io/qr?text=hello-world" + url;
            qrHref.value = url;
            //qrHref.innerHTML = url;
        }

        var elts = [qrText, qrSize, /* qrMargin, */ qrEc, qrFg, qrBg /* qrFormat , qrImageUrl*/ ];
        for (var i = 0; i < elts.length; i++) {
            var elt = elts[i];
            var type = elt.getAttribute('type');
            if (elt.tagName === 'INPUT' && (type === 'text' || type === 'number')) {
                elt.addEventListener('keyup', updateQr);
            } else {
                elt.addEventListener('change', updateQr);
            }
        }
    </script>