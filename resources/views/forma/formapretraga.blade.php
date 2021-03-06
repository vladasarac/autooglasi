


        <form role="form" method="GET" action="{{ url('/frontpretraga') }}">
          {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
          {{-- ovaj input salje kontroleru 1 ili 0 da bi znao da li je radjena detaljna(ako je 1) ili mala pretraga(ako je 0) --}}
          @if($detpretr0ili1 == 0)
            <input type="hidden" id="detpretr0ili1" name="detpretr0ili1" value="0">
          @else
            <input type="hidden" id="detpretr0ili1" name="detpretr0ili1" value="1">
          @endif
          <input type="hidden" id="sort" name="sort" value="{{ $sort }}">
          <input type="hidden" id="ascdesc" name="ascdesc" value="{{ $ascdesc }}">

          <div class="row">

            {{-- polje za marku --}}
            <div class="col-md-3">
              <div class="form-group form-group-sm">
                <label for="markaautomobila" id="markaautomobilalabel" class="control-label text-info">Marka Automobila</label>
                <select name="markaautomobila" id="markaautomobila" class="form-control obaveznopolje">
                  <option></option>
                  @foreach ($marke as $marka)
                    <option markaid="{{ $marka->id }}" value="{{ $marka->name }}"  {{ $markaautomobila == $marka->name ? 'selected' : '' }}>{{ $marka->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            {{-- polje za model --}}
            <div class="col-md-3">
              <div class="form-group form-group-sm">
                <label for="modelmarke" id="modelautomobilalabel" class="control-label text-info" id="labelzamodel">Model</label>
                <div id="modelmarkeselect">
                  <select name="modelmarke" id="modelmarke" class="form-control obaveznopolje">
                    @if($modeli == '')
                      <option id="prazanoptionzamodele"></option>
                    @else
                      <option></option>
                      @foreach($modeli as $model)
                        <option value="{{ $model->ime }}" {{ $modelpretraga == $model->ime ? 'selected' : '' }}>{{ $model->ime }}</option>
                      @endforeach
                      <option value="ostalo">Ostalo...</option>
                    @endif
                  </select>
                </div>
              </div>
            </div>
            {{-- polje za gorivo --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="gor" id="gorlabel" class="control-label text-info">Gorivo</label>
                <select name="gor" id="gor" class="form-control obaveznopolje">
                  <option></option>
                  <option value="benzin" {{ $gor == 'benzin' ? 'selected' : '' }}>Benzin</option>
                  <option value="dizel" {{ $gor == 'dizel' ? 'selected' : '' }}>Dizel</option>
                  <option value="benzingas" {{ $gor == 'benzingas' ? 'selected' : '' }}>Benzin + Gas(TNG)</option>
                  <option value="metan" {{ $gor == 'metan' ? 'selected' : '' }}>Metan CNG</option>
                  <option value="elektricni" {{ $gor == 'elektricni' ? 'selected' : '' }}>Električni Pogon</option>
                  <option value="hibrid" {{ $gor == 'hibrid' ? 'selected' : '' }}>Hibridni Pogon</option>
                </select>
              </div>
            </div>
            @php
              $g = 2017;
            @endphp
            {{-- polje za godiste od --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="godod" id="gododlabel" class="control-label text-info">Godište od</label>
                <select name="godod" id="godod" class="form-control">
                  <option></option>
                  @for($g; $g >= 1930; $g--)
                    <option value="{{ $g }}" {{ $g == $godod ? 'selected' : '' }}>{{ $g }}</option>
                  @endfor
                </select>
              </div>
            </div>
            @php
              $g1 = 2017;
            @endphp
            {{-- polje za godiste do --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="goddo" id="goddolabel" class="control-label text-info">Godište do</label>
                <select name="goddo" id="goddo" class="form-control">
                  <option></option>
                  @for($g1; $g1 >= 1930; $g1--)
                    <option value="{{ $g1 }}" {{ $g1 == $goddo ? 'selected' : '' }}>{{ $g1 }}</option>
                  @endfor
                </select>
              </div>
            </div>

          </div>{{--kraj diva row--}}

          <div class="row">

            {{-- polje za cenu od --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="cod" id="codlabel" class="control-label text-info">Cena od</label>
                <input type="number" name="cod" id="cod" min="1" max="1000000" class="form-control" value="{{ $cod == '' ? '' : $cod }}">
              </div>
            </div>
            {{-- polje za cenu do --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="cdo" id="cdolabel" class="control-label text-info">Cena do</label>
                <input type="number" name="cdo" id="cdo" min="1" max="1000000" class="form-control" value="{{ $cdo == '' ? '' : $cdo }}">
              </div>
            </div>
            {{-- polje za karoseriju --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="kar" id="karlabel" class="control-label text-info">Karoserija</label>
                <select name="kar" id="kar" class="form-control obaveznopolje">
                  <option></option>
                  <option value="limuzina" {{ $kar == 'limuzina' ? 'selected' : '' }}>Limuzina</option>
                  <option value="hecbek" {{ $kar == 'hecbek' ? 'selected' : '' }}>Hečbek</option>
                  <option value="karavan" {{ $kar == 'karavan' ? 'selected' : '' }}>Karavan</option>
                  <option value="kupe" {{ $kar == 'kupe' ? 'selected' : '' }}>Kupe</option>
                  <option value="kabriolet" {{ $kar == 'kabriolet' ? 'selected' : '' }}>Kabriolet</option>
                  <option value="minivan" {{ $kar == 'minivan' ? 'selected' : '' }}>Mini Van</option>
                  <option value="suv" {{ $kar == 'suv' ? 'selected' : '' }}>SUV</option>
                  <option value="pickup" {{ $kar == 'pickup' ? 'selected' : '' }}>Pickup</option>
                </select>
              </div>
            </div>
            {{-- polje za kubikazu od --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="kubod" id="kubodlabel" class="control-label text-info">Kubikaža od</label>
                <select name="kubod" id="kubod" class="form-control obaveznopolje">
                  <option></option>
                  <option value="500" {{ $kubod == 500 ? 'selected' : '' }}>500 cm<sup>3</sup></option>
                  <option value="1150" {{ $kubod == 1150 ? 'selected' : '' }}>1150 cm<sup>3</sup></option>
                  <option value="1300" {{ $kubod == 1300 ? 'selected' : '' }}>1300 cm<sup>3</sup></option>
                  <option value="1600" {{ $kubod == 1600 ? 'selected' : '' }}>1600 cm<sup>3</sup></option>
                  <option value="1800" {{ $kubod == 1800 ? 'selected' : '' }}>1800 cm<sup>3</sup></option>
                  <option value="2000" {{ $kubod == 2000 ? 'selected' : '' }}>2000 cm<sup>3</sup></option>
                  <option value="2500" {{ $kubod == 2500 ? 'selected' : '' }}>2500 cm<sup>3</sup></option>
                  <option value="3000" {{ $kubod == 3000 ? 'selected' : '' }}>3000 cm<sup>3</sup></option>
                  <option value="3500" {{ $kubod == 3500 ? 'selected' : '' }}>3500 cm<sup>3</sup></option>
                  <option value="4000" {{ $kubod == 4000 ? 'selected' : '' }}>4000 cm<sup>3</sup></option>
                  <option value="4500" {{ $kubod == 4500 ? 'selected' : '' }}>4500 cm<sup>3</sup></option>
                </select>
              </div>
            </div>
            {{-- polje za kubikazu od --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="kubdo" id="kubdolabel" class="control-label text-info">Kubikaža do</label>
                <select name="kubdo" id="kubdo" class="form-control obaveznopolje">
                  <option></option>
                  <option value="500" {{ $kubdo == 500 ? 'selected' : '' }}>500 cm<sup>3</sup></option>
                  <option value="1150" {{ $kubdo == 1150 ? 'selected' : '' }}>1150 cm<sup>3</sup></option>
                  <option value="1300" {{ $kubdo == 1300 ? 'selected' : '' }}>1300 cm<sup>3</sup></option>
                  <option value="1600" {{ $kubdo == 1600 ? 'selected' : '' }}>1600 cm<sup>3</sup></option>
                  <option value="1800" {{ $kubdo == 1800 ? 'selected' : '' }}>1800 cm<sup>3</sup></option>
                  <option value="2000" {{ $kubdo == 2000 ? 'selected' : '' }}>2000 cm<sup>3</sup></option>
                  <option value="2500" {{ $kubdo == 2500 ? 'selected' : '' }}>2500 cm<sup>3</sup></option>
                  <option value="3000" {{ $kubdo == 3000 ? 'selected' : '' }}>3000 cm<sup>3</sup></option>
                  <option value="3500" {{ $kubdo == 3500 ? 'selected' : '' }}>3500 cm<sup>3</sup></option>
                  <option value="4000" {{ $kubdo == 4000 ? 'selected' : '' }}>4000 cm<sup>3</sup></option>
                  <option value="4500" {{ $kubdo == 4500 ? 'selected' : '' }}>4500 cm<sup>3</sup></option>
                </select>
              </div>
            </div>
            {{-- prikazati ostecene ili ne ili samo ostecene --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="ost" id="ostlabel" class="control-label text-info">Prikaži oštećene</label>
                <select name="ost" id="ost" class="form-control obaveznopolje">
                  <option value="1" {{ $ost == 1 ? 'selected' : '' }}>Ne</option>
                  <option value="2" {{ $ost == 2 ? 'selected' : '' }}>Da</option>
                  <option value="3" {{ $ost == 3 ? 'selected' : '' }}>Samo oštećeni</option>
                  <option value="4" {{ $ost == 4 ? 'selected' : '' }}>Samo koji nisu u voznom stanju</option>
                </select>        
              </div>
            </div>
            
          </div>{{--kraj diva row--}}

          {{-- DETALJNA PRETRAGA --}}
          @if($detpretr0ili1 == 0)
            <div class="detaljnapretraga" hidden="true">
          @else
            <div class="detaljnapretraga">
          @endif
            <div class="row">
              
              {{-- polje za emisionu klasu --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="emkl" id="emklabel" class="control-label text-info">Emisiona klasa</label>
                  <select name="emkl" id="emkl" class="form-control obaveznopolje">
                    <option></option>
                    <option value="euro1" {{ $emkl == 'euro1' ? 'selected' : '' }}>Euro 1</option>
                    <option value="euro2" {{ $emkl == 'euro2' ? 'selected' : '' }}>Euro 2</option>
                    <option value="euro3" {{ $emkl == 'euro3' ? 'selected' : '' }}>Euro 3</option>
                    <option value="euro4" {{ $emkl == 'euro4' ? 'selected' : '' }}>Euro 4</option>
                    <option value="euro5" {{ $emkl == 'euro5' ? 'selected' : '' }}>Euro 5</option>
                    <option value="euro6" {{ $emkl == 'euro6' ? 'selected' : '' }}>Euro 6</option>
                  </select>
                </div>
              </div>
              {{-- polje za kubikazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="snod" id="snodlabel" class="control-label text-info">Snaga od(KS)</label>
                  <select name="snod" id="snod" class="form-control obaveznopolje">
                    <option></option>
                    <option value="34" {{ $snod == 34 ? 'selected' : '' }}>34 KS (25kW)</option>
                    <option value="48" {{ $snod == 48 ? 'selected' : '' }}>48 KS (35kW)</option>
                    <option value="60" {{ $snod == 60 ? 'selected' : '' }}>60 KS (44kW)</option>
                    <option value="75" {{ $snod == 75 ? 'selected' : '' }}>75 KS (55kW)</option>
                    <option value="90" {{ $snod == 90 ? 'selected' : '' }}>90 KS (67kW)</option>
                    <option value="101" {{ $snod == 101 ? 'selected' : '' }}>101 KS (75kW)</option>
                    <option value="116" {{ $snod == 116 ? 'selected' : '' }}>116 KS (86kW)</option>
                    <option value="131" {{ $snod == 131 ? 'selected' : '' }}>131 KS (97kW)</option>
                    <option value="150" {{ $snod == 150 ? 'selected' : '' }}>150 KS (111kW)</option>
                    <option value="200" {{ $snod == 200 ? 'selected' : '' }}>200 KS (149kW)</option>
                    <option value="250" {{ $snod == 250 ? 'selected' : '' }}>250 KS (186kW)</option>
                    <option value="302" {{ $snod == 302 ? 'selected' : '' }}>302 KS (225kW)</option>
                    <option value="356" {{ $snod == 356 ? 'selected' : '' }}>356 KS (265kW)</option>
                    <option value="402" {{ $snod == 402 ? 'selected' : '' }}>402 KS (299kW)</option>
                    <option value="453" {{ $snod == 453 ? 'selected' : '' }}>453 KS (337kW)</option>
                    <option value="500" {{ $snod == 500 ? 'selected' : '' }}>500 KS (372kW)</option>
                  </select>
                </div>
              </div>
              {{-- polje za kubikazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="sndo" id="sndolabel" class="control-label text-info">Snaga do(KS)</label>
                  <select name="sndo" id="sndo" class="form-control obaveznopolje">
                    <option></option>
                    <option value="34" {{ $sndo == 34 ? 'selected' : '' }}>34 KS (25kW)</option>
                    <option value="48" {{ $sndo == 48 ? 'selected' : '' }}>48 KS (35kW)</option>
                    <option value="60" {{ $sndo == 60 ? 'selected' : '' }}>60 KS (44kW)</option>
                    <option value="75" {{ $sndo == 75 ? 'selected' : '' }}>75 KS (55kW)</option>
                    <option value="90" {{ $sndo == 90 ? 'selected' : '' }}>90 KS (67kW)</option>
                    <option value="101" {{ $sndo == 101 ? 'selected' : '' }}>101 KS (75kW)</option>
                    <option value="116" {{ $sndo == 116 ? 'selected' : '' }}>116 KS (86kW)</option>
                    <option value="131" {{ $sndo == 131 ? 'selected' : '' }}>131 KS (97kW)</option>
                    <option value="150" {{ $sndo == 150 ? 'selected' : '' }}>150 KS (111kW)</option>
                    <option value="200" {{ $sndo == 200 ? 'selected' : '' }}>200 KS (149kW)</option>
                    <option value="250" {{ $sndo == 250 ? 'selected' : '' }}>250 KS (186kW)</option>
                    <option value="302" {{ $sndo == 302 ? 'selected' : '' }}>302 KS (225kW)</option>
                    <option value="356" {{ $sndo == 356 ? 'selected' : '' }}>356 KS (265kW)</option>
                    <option value="402" {{ $sndo == 402 ? 'selected' : '' }}>402 KS (299kW)</option>
                    <option value="453" {{ $sndo == 453 ? 'selected' : '' }}>453 KS (337kW)</option>
                    <option value="500" {{ $sndo == 500 ? 'selected' : '' }}>500 KS (372kW)</option>
                  </select>
                </div>
              </div>
              {{-- polje za kilometrazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="kilod" id="kilodlabel" class="control-label text-info">Kilometraža od</label>
                  <select name="kilod" id="kilod" class="form-control obaveznopolje">
                    <option></option>
                    <option value="1000" {{ $kilod == 1000 ? 'selected' : '' }}>1000 km</option>
                    <option value="10000" {{ $kilod == 10000 ? 'selected' : '' }}>10000 km</option>
                    <option value="25000" {{ $kilod == 25000 ? 'selected' : '' }}>25000 km</option>
                    <option value="50000" {{ $kilod == 50000 ? 'selected' : '' }}>50000 km</option>
                    <option value="75000" {{ $kilod == 75000 ? 'selected' : '' }}>75000 km</option>
                    <option value="100000" {{ $kilod == 100000 ? 'selected' : '' }}>100000 km</option>
                    <option value="125000" {{ $kilod == 125000 ? 'selected' : '' }}>125000 km</option>
                    <option value="150000" {{ $kilod == 150000 ? 'selected' : '' }}>150000 km</option>
                    <option value="200000" {{ $kilod == 200000 ? 'selected' : '' }}>200000 km</option>
                    <option value="250000" {{ $kilod == 250000 ? 'selected' : '' }}>250000 km</option>
                    <option value="300000" {{ $kilod == 300000 ? 'selected' : '' }}>300000 km</option>
                  </select>
                </div>
              </div>
              {{-- polje za kilometrazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="kildo" id="kildolabel" class="control-label text-info">Kilometraža do</label>
                  <select name="kildo" id="kildo" class="form-control obaveznopolje">
                    <option></option>
                    <option value="1000" {{ $kildo == 1000 ? 'selected' : '' }}>1000 km</option>
                    <option value="10000" {{ $kildo == 10000 ? 'selected' : '' }}>10000 km</option>
                    <option value="25000" {{ $kildo == 25000 ? 'selected' : '' }}>25000 km</option>
                    <option value="50000" {{ $kildo == 50000 ? 'selected' : '' }}>50000 km</option>
                    <option value="75000" {{ $kildo == 75000 ? 'selected' : '' }}>75000 km</option>
                    <option value="100000" {{ $kildo == 100000 ? 'selected' : '' }}>100000 km</option>
                    <option value="125000" {{ $kildo == 125000 ? 'selected' : '' }}>125000 km</option>
                    <option value="150000" {{ $kildo == 150000 ? 'selected' : '' }}>150000 km</option>
                    <option value="200000" {{ $kildo == 200000 ? 'selected' : '' }}>200000 km</option>
                    <option value="250000" {{ $kildo == 250000 ? 'selected' : '' }}>250000 km</option>
                    <option value="300000" {{ $kildo == 300000 ? 'selected' : '' }}>300000 km</option>
                  </select>
                </div>
              </div>
              {{-- polje za pogon --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="pog" id="poglabel" class="control-label text-info">Pogon</label>
                  <select name="pog" id="pog" class="form-control obaveznopolje">
                    <option></option>
                    <option value="p" {{ $pog == 'p' ? 'selected' : '' }}>Prednji</option>
                    <option value="z" {{ $pog == 'z' ? 'selected' : '' }}>Zadnji</option>
                    <option value="4x4" {{ $pog == '4x4' ? 'selected' : '' }}>4x4</option>
                    <option value="4x4r" {{ $pog == '4x4r' ? 'selected' : '' }}>4x4 reduktor</option>
                  </select>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{-- polje za menjac --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="menj" id="menjlabel" class="control-label text-info">Menjač</label>
                  <select name="menj" id="menj" class="form-control obaveznopolje">
                    <option></option>
                    <option value="m4" {{ $menj == 'm4' ? 'selected' : '' }}>Manuelni 4 brzine</option>
                    <option value="m5" {{ $menj == 'm5' ? 'selected' : '' }}>Manuelni 5 brzina</option>
                    <option value="m6" {{ $menj == 'm6' ? 'selected' : '' }}>Manuelni 6 brzina</option>
                    <option value="pa" {{ $menj == 'pa' ? 'selected' : '' }}>Poluautomatski</option>
                    <option value="a" {{ $menj == 'a' ? 'selected' : '' }}>Automatski</option>
                  </select>
                </div>
              </div>  
              {{-- polje za br vrata --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="brvr" id="brvrlabel" class="control-label text-info">Broj vrata</label>
                  <select name="brvr" id="brvr" class="form-control obaveznopolje">
                    <option></option>
                    <option value="3" {{ $brvr == '3' ? 'selected' : '' }}>2/3 vrata</option>
                    <option value="4" {{ $brvr == '4' ? 'selected' : '' }}>4/5 vrata</option>
                  </select>
                </div>
              </div>
              {{-- polje za br sedista --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="brsed" id="brsedlabel" class="control-label text-info">Broj sedišta</label>
                  <select name="brsed" id="brsed" class="form-control obaveznopolje">
                    <option></option>
                    <option value="2" {{ $brsed == '2' ? 'selected' : '' }}>2 Sedišta</option>
                    <option value="3" {{ $brsed == '3' ? 'selected' : '' }}>3 Sedišta</option>
                    <option value="4" {{ $brsed == '4' ? 'selected' : '' }}>4 Sedišta</option>
                    <option value="5" {{ $brsed == '5' ? 'selected' : '' }}>5 Sedišta</option>
                    <option value="6" {{ $brsed == '6' ? 'selected' : '' }}>6 Sedišta</option>
                    <option value="7" {{ $brsed == '7' ? 'selected' : '' }}>7 Sedišta</option>
                    <option value="8" {{ $brsed == '8' ? 'selected' : '' }}>8 Sedišta</option>
                    <option value="9" {{ $brsed == '9' ? 'selected' : '' }}>9 Sedišta</option>
                  </select>
                </div>
              </div>  
              {{-- polje za stranu volana --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="strvol" id="strvollabel" class="control-label text-info">Strana volana</label>
                  <select name="strvol" id="strvol" class="form-control obaveznopolje">
                    <option></option>
                    <option value="l" {{ $strvol == 'l' ? 'selected' : '' }}>Levi Volan</option>
                    <option value="d" {{ $strvol == 'd' ? 'selected' : '' }}>Desni Volan</option>
                  </select>
                </div>
              </div>
              {{-- polje za klimu --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="kli" id="klilabel" class="control-label text-info">Klima</label>
                  <select name="kli" id="kli" class="form-control obaveznopolje">
                    <option></option>
                    <option value="0" {{ $kli == '0' ? 'selected' : '' }}>Bez Klime</option>
                    <option value="mk" {{ $kli == 'mk' ? 'selected' : '' }}>Manuelna Klima</option>
                    <option value="ak" {{ $kli == 'ak' ? 'selected' : '' }}>Automatska Klima</option>
                  </select>
                </div>
              </div>
              {{-- polje za boju, obavezno --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="boja" id="bojalabel" class="control-label text-info">Boja</label>
                  <select name="boja" id="boja" class="form-control obaveznopolje">
                    <option></option>
                    <option value="bela" {{ $boja == 'bela' ? 'selected' : '' }}>Bela</option>
                    <option value="bez" {{ $boja == 'bez' ? 'selected' : '' }}>Bež</option>
                    <option value="bordo" {{ $boja == 'bordo' ? 'selected' : '' }}>Bordo</option>
                    <option value="braon" {{ $boja == 'braon' ? 'selected' : '' }}>Braon</option>
                    <option value="crna" {{ $boja == 'crna' ? 'selected' : '' }}>Crna</option>
                    <option value="crvena" {{ $boja == 'crvena' ? 'selected' : '' }}>Crvena</option>
                    <option value="kameleon" {{ $boja == 'kameleon' ? 'selected' : '' }}>Kameleon</option>
                    <option value="ljubicasta" {{ $boja == 'ljubicasta' ? 'selected' : '' }}>Ljubičasta</option>
                    <option value="narandzasta" {{ $boja == 'narandzasta' ? 'selected' : '' }}>Narandžasta</option>
                    <option value="plava" {{ $boja == 'plava' ? 'selected' : '' }}>Plava</option>
                    <option value="siva" {{ $boja == 'siva' ? 'selected' : '' }}>Siva</option>
                    <option value="srebrna" {{ $boja == 'srebrna' ? 'selected' : '' }}>Srebrna</option>
                    <option value="tirkiz" {{ $boja == 'tirkiz' ? 'selected' : '' }}>Tirkiz</option>
                    <option value="teget" {{ $boja == 'teget' ? 'selected' : '' }}>Teget</option>
                    <option value="zelena" {{ $boja == 'zelena' ? 'selected' : '' }}>Zelena</option>
                    <option value="zuta" {{ $boja == 'zuta' ? 'selected' : '' }}>Žuta</option>
                  </select>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{-- polje za poreklo --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="por" id="porlabel" class="control-label text-info">Poreklo</label>
                  <select name="por" id="por" class="form-control obaveznopolje">
                    <option></option>
                    <option value="dt" {{ $por == 'dt' ? 'selected' : '' }}>Domace tablice</option>
                    <option value="st" {{ $por == 'st' ? 'selected' : '' }}>Strane tablice</option>
                    <option value="nik" {{ $por == 'nik' ? 'selected' : '' }}>Na ime kupca</option>
                  </select>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <h4 class="frontformah4">Sigurnost</h4>

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $airb == 1 ? 'checked' : '' }} id="airb" name="airb" value="1"> <small>Airbag</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $cloc == 1 ? 'checked' : '' }} id="cloc" name="cloc" value="1"> <small>Child lock</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $abs == 1 ? 'checked' : '' }} id="abs" name="abs" value="1"> <small>ABS</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $esp == 1 ? 'checked' : '' }} id="esp" name="esp" value="1"> <small>ESP</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $asr == 1 ? 'checked' : '' }} id="asr" name="asr" value="1"> <small>ASR</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $alrm == 1 ? 'checked' : '' }} id="alrm" name="alrm" value="1"> <small>Alarm</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $kodk == 1 ? 'checked' : '' }} id="kodk" name="kodk" value="1"> <small>Kodiran ključ</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $zdr == 1 ? 'checked' : '' }} id="zdr" name="zdr" value="1"> <small>Zeder</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $blkm == 1 ? 'checked' : '' }} id="blkm" name="blkm" value="1"><small>Blokada motora</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $cbr == 1 ? 'checked' : '' }} id="cbr" name="cbr" value="1"><small>Centralna brava</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <h4 class="frontformah4">Oprema</h4>

            <div class="row">
              
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $mboj == 1 ? 'checked' : '' }} id="mboj" name="mboj" value="1"> <small>Metalik boja</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $svol == 1 ? 'checked' : '' }} id="svol" name="svol" value="1"> <small>Servo volan</small>
                  </label>
                </div>
              </div>    
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $mvol == 1 ? 'checked' : '' }} id="mvol" name="mvol" value="1"> <small>Multi volan</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $tmpt == 1 ? 'checked' : '' }} id="tmpt" name="tmpt" value="1"> <small>Tempomat</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $prac == 1 ? 'checked' : '' }} id="prac" name="prac" value="1"> <small>Putni računar</small>
                  </label>
                </div>
              </div>    
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $sibr == 1 ? 'checked' : '' }} id="sibr" name="sibr" value="1"> <small>Šiber</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">
              
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $pkr == 1 ? 'checked' : '' }} id="pkr" name="pkr" value="1"> <small>Panorama krov</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $elpo == 1 ? 'checked' : '' }} id="elpo" name="elpo" value="1"> <small>El. podizači</small>
                  </label>
                </div>
              </div>    
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $elr == 1 ? 'checked' : '' }} id="elr" name="elr" value="1"> <small>El. retrovizori</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $gret == 1 ? 'checked' : '' }} id="gret" name="gret" value="1"> <small>Grejači retrovizora</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $elps == 1 ? 'checked' : '' }} id="elps" name="elps" value="1"> <small>El.podesiva sed</small>
                  </label>
                </div>
              </div>    
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $gsed == 1 ? 'checked' : '' }} id="gsed" name="gsed" value="1"> <small>Grejanje sedišta</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $szm == 1 ? 'checked' : '' }} id="szm" name="szm" value="1"> <small>Svetla za maglu</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $xen == 1 ? 'checked' : '' }} id="xen" name="xen" value="1"> <small>Xenon svetla</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $led == 1 ? 'checked' : '' }} id="led" name="led" value="1"> <small>LED svetla</small>
                  </label>
                </div>
              </div>    
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $senzzs == 1 ? 'checked' : '' }} id="senzzs" name="senzzs" value="1"> <small>Senzori za svetla</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $senzzk == 1 ? 'checked' : '' }} id="senzzk" name="senzzk" value="1"> <small>Senzori za kišu</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $senzzp == 1 ? 'checked' : '' }} id="senzzp" name="senzzp" value="1"> <small>Parking senzori</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $krno == 1 ? 'checked' : '' }} id="krno" name="krno" value="1"> <small>Krovni nosač</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $kzv == 1 ? 'checked' : '' }} id="kzv" name="kzv" value="1"> <small>Kuka za vuču</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $aluf == 1 ? 'checked' : '' }} id="aluf" name="aluf" value="1"> <small>Alu. felne</small>
                  </label>
                </div>
              </div>    
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $nav == 1 ? 'checked' : '' }} id="nav" name="nav" value="1"> <small>Navigacija</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $rdio == 1 ? 'checked' : '' }} id="rdio" name="rdio" value="1"> <small>Radio</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $cdp == 1 ? 'checked' : '' }} id="cdp" name="cdp" value="1"> <small>CD Player</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $dvd == 1 ? 'checked' : '' }} id="dvd" name="dvd" value="1"> <small>DVD/TV</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $wbs == 1 ? 'checked' : '' }} id="wbs" name="wbs" value="1"> <small>Webasto</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $grve == 1 ? 'checked' : '' }} id="grve" name="grve" value="1"> <small>Grejači vetrobrana</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $koza == 1 ? 'checked' : '' }} id="koza" name="koza" value="1"> <small>Kožna sedišta</small>
                  </label>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <h4 class="frontformah4">Stanje</h4>

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $prv == 1 ? 'checked' : '' }} id="prv" name="prv" value="1"> <small>Prvi vlasnik</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $knus == 1 ? 'checked' : '' }} id="knus" name="knus" value="1"> <small>Kupljen nov u SRB</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $gar == 1 ? 'checked' : '' }} id="gar" name="gar" value="1"> <small>Garancija</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $garaz == 1 ? 'checked' : '' }} id="garaz" name="garaz" value="1"> <small>Garažiran</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $serknj == 1 ? 'checked' : '' }} id="serknj" name="serknj" value="1"> <small>Servis. Knjiga</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $rezklj == 1 ? 'checked' : '' }} id="rezklj" name="rezklj" value="1"> <small>Rezervni ključ</small>
                  </label>
                </div>
              </div>
              
            </div>{{--kraj diva row--}}

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $tun == 1 ? 'checked' : '' }} id="tun" name="tun" value="1"> <small>Tuning</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $old == 1 ? 'checked' : '' }} id="old" name="old" value="1"> <small>Oldtimer</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $test == 1 ? 'checked' : '' }} id="test" name="test" value="1"> <small>Test vozilo</small>
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" {{ $taxi == 1 ? 'checked' : '' }} id="taxi" name="taxi" value="1"> <small>Taxi</small>
                  </label>
                </div>
              </div>
              
            </div>{{--kraj diva row--}}
          
          </div>{{--kraj div-a .detaljnapretraga--}}
          
          <div class="row">
            
            {{-- submit btn --}}
            <div class="col-md-6">
              <div class="form-group form-group-sm">
                <input type="submit" id="pretrazi" name="pretrazi" class="sabmint btn btn-block btn-success" value="Pretraži">
              </div>
            </div>
            {{-- btn za prikaz detaljne pretrage tj nastavak forme --}}
            @if($detpretr0ili1 == 0)
              <div class="col-md-6">
                <div class="form-group form-group-sm">
                  <input id="detaljna" name="detaljna" class="sabmint btn btn-block btn-info" value="Detaljna Pretraga">
                </div>
              </div>
            @endif
          </div>

        </form>    
