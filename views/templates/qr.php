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
                filter: blur(1.5px);
                pointer-events: none;
                cursor: default;
            }
        <?php endif;?>    
    </style>
    <?php if($suscripcion['EditarQR']=='NO'):?>
    <h4 style="color:tomato">Por favor Actualiza tu Membresia 🎁</h4>
    <?php endif;?>  
<div class="contEDIT">  
    <div class="hero">
        <div class="columna">
            <div>
                <input id="<?=$qrText?>" type="hidden" value="Hello world lorem Hello world lorem Hello world lorem ">
                <input id="<?=$qrSize?>" type="hidden" value="300">
                <div class="form-group">
                    <div class="col label">Color (foreground)</div>
                    <div class="col">
                        <input id="<?=$qrFg?>" type="color" value="#000000">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col label">Color (background)</div>
                    <div class="col">
                        <input id="<?=$qrBg?>" type="color" value="#ffffff">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col label">Error correction</div>
                    <div class="col">
                        <select id="<?=$qrEc?>">
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
            <img id="<?=$qrimg?>" src="https://quickchart.io/qr?text=Hello world&amp;size=200">
        </div>
    </div>
</div>
    </script>
    <script type="text/javascript">
        var <?=$qrText?> = document.getElementById('<?=$qrText?>');
        var <?=$qrSize?> = document.getElementById('<?=$qrSize?>');
        var <?=$qrEc?> = document.getElementById('<?=$qrEc?>');
        var <?=$qrFg?>= document.getElementById('<?=$qrFg?>');
        var <?=$qrBg?>= document.getElementById('<?=$qrBg?>');

        var <?=$qrimg?> = document.getElementById('<?=$qrimg?>');
        var <?=$qrhref?>=document.getElementById('<?=$qrhref?>');

        <?=$qrEc?>.addEventListener('click',()=>{
            <?=$qrhref?>.name = 'QRatributo';
        })
        <?=$qrFg?>.addEventListener('click',()=>{
            <?=$qrhref?>.name = 'QRatributo';
        })
        <?=$qrBg?>.addEventListener('click',()=>{
            <?=$qrhref?>.name = 'QRatributo';
        })

        function <?=$updateQr?>() {
            if (!<?=$qrText?>.value) {
                return;
            }
            var <?=$url?> = '';

            if (<?=$qrBg?>.value != '#ffffff') {
                <?=$url?> += '&light=' + <?=$qrBg?>.value.slice(1);
            }
            if (<?=$qrFg?>.value != '#000000') {
                <?=$url?> += '&dark=' + <?=$qrFg?>.value.slice(1);
            }
            if (<?=$qrEc?>.value != 'M') {
                <?=$url?> += '&ecLevel=' + <?=$qrEc?>.value;
            }
            if (<?=$qrSize?>.value != 4) {
                <?=$url?> += '&size=' + <?=$qrSize?>.value;
            }

            <?=$qrimg?>.src = "https://quickchart.io/qr?text=hello-world" + <?=$url?>;
            <?=$qrhref?>.value = <?=$url?>;
            //qrHref.innerHTML = url;
        }

        var <?=$elts?> = [<?=$qrText?>, <?=$qrSize?>, <?=$qrEc?>, <?=$qrFg?>, <?=$qrBg?>  ];
        for (var <?=$i?> = 0; <?=$i?> < <?=$elts?>.length; <?=$i?>++) {
            var <?=$elt?> = <?=$elts?>[<?=$i?>];
            var <?=$type?> = <?=$elt?>.getAttribute('type');
            if (<?=$elt?>.tagName === 'INPUT' && (<?=$type?> === 'text' || <?=$type?> === 'number')) {
                <?=$elt?>.addEventListener('keyup', <?=$updateQr?>);
            } else {
                <?=$elt?>.addEventListener('change', <?=$updateQr?>);
            }
        }
        console.log('<?=$qrText?>');

    </script>