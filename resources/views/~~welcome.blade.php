@extends('layouts.app')

@section('content')
{{-- pocetni vju sajta, poziva ga index() metod FrontControllera --}}

@php
  //
  if(!isset($modeli)){
    $modeli = '';
  }
@endphp

{{-- div se koristi u welcome.js da se izmeri sirina ekrana --}}
<div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div> 

{{-- <div class="container"> --}}
  <div class="row">
    <div class="col-md-10 col-md-offset-1 col-xs-12">

      <h3 class="text-center naslovpretraga shadow">Pretraga <img src="{{ asset('img/searchcars1.png') }}" style="height:25px; width:25px;"></h3>
      
      {{-- osnovna forma za pretragu oglasa --}}
      <div class="formapretraga" hidden="true">

        {{-- hendler za klik na ovu ikonu je u welcome.js i on divu formapretraga dodaje attr hidden="true"--}}
        <div class="row">
          <img src="{{ asset('img/closeplava.png') }}" style="margin-right: 20px;" class="pull-right closebtn zatvoriformuzapretragu">
        </div>

        <form role="form" method="POST" action="{{ url('/frontpretraga') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          {{-- ovaj input salje kontroleru 1 ili 0 da bi znao da li je radjena detaljna(ako je 1) ili mala pretraga(ako je 0) --}}
          <input type="hidden" id="detpretr0ili1" name="detpretr0ili1" value="0">

          <div class="row">

            {{-- polje za marku --}}
            <div class="col-md-3">
              <div class="form-group form-group-sm">
                <label for="markaautomobila" id="markaautomobilalabel" class="control-label text-info">Marka Automobila</label>
                <select name="markaautomobila" id="markaautomobila" class="form-control obaveznopolje">
                  <option></option>
                  @foreach ($marke as $marka)
                    <option markaid="{{ $marka->id }}" value="{{ $marka->name }}" >{{ $marka->name }}</option>
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
                        <option value="{{ $model->ime }}">{{ $model->ime }}</option>
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
                  <option value="benzin">Benzin</option>
                  <option value="dizel">Dizel</option>
                  <option value="benzingas">Benzin + Gas(TNG)</option>
                  <option value="metan">Metan CNG</option>
                  <option value="elektricni">Električni Pogon</option>
                  <option value="hibrid">Hibridni Pogon</option>
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
                    <option value="{{ $g }}">{{ $g }}</option>
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
                    <option value="{{ $g1 }}">{{ $g1 }}</option>
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
                <input type="number" name="cod" id="cod" min="1" max="1000000" class="form-control">
              </div>
            </div>
            {{-- polje za cenu do --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="cdo" id="cdolabel" class="control-label text-info">Cena do</label>
                <input type="number" name="cdo" id="cdo" min="1" max="1000000" class="form-control">
              </div>
            </div>
            {{-- polje za karoseriju --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="kar" id="karlabel" class="control-label text-info">Karoserija</label>
                <select name="kar" id="kar" class="form-control obaveznopolje">
                  <option></option>
                  <option value="limuzina">Limuzina</option>
                  <option value="hecbek">Hečbek</option>
                  <option value="karavan">Karavan</option>
                  <option value="kupe">Kupe</option>
                  <option value="kabriolet">Kabriolet</option>
                  <option value="minivan">Mini Van</option>
                  <option value="suv">SUV</option>
                  <option value="pickup">Pickup</option>
                </select>
              </div>
            </div>
            {{-- polje za kubikazu od --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="kubod" id="kubodlabel" class="control-label text-info">Kubikaža od</label>
                <select name="kubod" id="kubod" class="form-control obaveznopolje">
                  <option></option>
                  <option value="500">500 cm<sup>3</sup></option>
                  <option value="1150">1150 cm<sup>3</sup></option>
                  <option value="1300">1300 cm<sup>3</sup></option>
                  <option value="1600">1600 cm<sup>3</sup></option>
                  <option value="1800">1800 cm<sup>3</sup></option>
                  <option value="2000">2000 cm<sup>3</sup></option>
                  <option value="2500">2500 cm<sup>3</sup></option>
                  <option value="3000">3000 cm<sup>3</sup></option>
                  <option value="3500">3500 cm<sup>3</sup></option>
                  <option value="4000">4000 cm<sup>3</sup></option>
                  <option value="4500">4500 cm<sup>3</sup></option>
                </select>
              </div>
            </div>
            {{-- polje za kubikazu od --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm">
                <label for="kubdo" id="kubdolabel" class="control-label text-info">Kubikaža do</label>
                <select name="kubdo" id="kubdo" class="form-control obaveznopolje">
                  <option></option>
                  <option value="500">500 cm<sup>3</sup></option>
                  <option value="1150">1150 cm<sup>3</sup></option>
                  <option value="1300">1300 cm<sup>3</sup></option>
                  <option value="1600">1600 cm<sup>3</sup></option>
                  <option value="1800">1800 cm<sup>3</sup></option>
                  <option value="2000">2000 cm<sup>3</sup></option>
                  <option value="2500">2500 cm<sup>3</sup></option>
                  <option value="3000">3000 cm<sup>3</sup></option>
                  <option value="3500">3500 cm<sup>3</sup></option>
                  <option value="4000">4000 cm<sup>3</sup></option>
                  <option value="4500">4500 cm<sup>3</sup></option>
                </select>
              </div>
            </div>
            {{-- prikazati ostecene ili ne ili samo ostecene --}}
            <div class="col-md-2">
              <div class="form-group form-group-sm {{ $errors->has('ostecen') ? ' has-error' : '' }}">
                <label for="ost" id="ostlabel" class="control-label text-info">Prikaži oštećene</label>
                <select name="ost" id="ost" class="form-control obaveznopolje">
                  <option value="1" selected>Ne</option>
                  <option value="2">Da</option>
                  <option value="3">Samo oštećeni</option>
                  <option value="4">Samo koji nisu u voznom stanju</option>
                </select>        
              </div>
            </div>
            
          </div>{{--kraj diva row--}}

          {{-- DETALJNA PRETRAGA --}}
          <div class="detaljnapretraga" hidden="true">
            <div class="row">
              
              {{-- polje za emisionu klasu --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="emkl" id="emklabel" class="control-label text-info">Emisiona klasa</label>
                  <select name="emkl" id="emkl" class="form-control obaveznopolje">
                    <option></option>
                    <option value="euro1">Euro 1</option>
                    <option value="euro2">Euro 2</option>
                    <option value="euro3">Euro 3</option>
                    <option value="euro4">Euro 4</option>
                    <option value="euro5">Euro 5</option>
                    <option value="euro6">Euro 6</option>
                  </select>
                </div>
              </div>
              {{-- polje za kubikazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="snod" id="snodlabel" class="control-label text-info">Snaga od(KS)</label>
                  <select name="snod" id="snod" class="form-control obaveznopolje">
                    <option></option>
                    <option value="34">34 KS (25kW)</option>
                    <option value="48">48 KS (35kW)</option>
                    <option value="60">60 KS (44kW)</option>
                    <option value="75">75 KS (55kW)</option>
                    <option value="90">90 KS (67kW)</option>
                    <option value="101">101 KS (75kW)</option>
                    <option value="116">116 KS (86kW)</option>
                    <option value="131">131 KS (97kW)</option>
                    <option value="150">150 KS (111kW)</option>
                    <option value="200">200 KS (149kW)</option>
                    <option value="250">250 KS (186kW)</option>
                    <option value="302">302 KS (225kW)</option>
                    <option value="356">356 KS (265kW)</option>
                    <option value="402">402 KS (299kW)</option>
                    <option value="453">453 KS (337kW)</option>
                    <option value="500">500 KS (372kW)</option>
                  </select>
                </div>
              </div>
              {{-- polje za kubikazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="sndo" id="sndolabel" class="control-label text-info">Snaga do(KS)</label>
                  <select name="sndo" id="sndo" class="form-control obaveznopolje">
                    <option></option>
                    <option value="34">34 KS (25kW)</option>
                    <option value="48">48 KS (35kW)</option>
                    <option value="60">60 KS (44kW)</option>
                    <option value="75">75 KS (55kW)</option>
                    <option value="90">90 KS (67kW)</option>
                    <option value="101">101 KS (75kW)</option>
                    <option value="116">116 KS (86kW)</option>
                    <option value="131">131 KS (97kW)</option>
                    <option value="150">150 KS (111kW)</option>
                    <option value="200">200 KS (149kW)</option>
                    <option value="250">250 KS (186kW)</option>
                    <option value="302">302 KS (225kW)</option>
                    <option value="356">356 KS (265kW)</option>
                    <option value="402">402 KS (299kW)</option>
                    <option value="453">453 KS (337kW)</option>
                    <option value="500">500 KS (372kW)</option>
                  </select>
                </div>
              </div>
              {{-- polje za kilometrazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="kilod" id="kilodlabel" class="control-label text-info">Kilometraža od</label>
                  <select name="kilod" id="kilod" class="form-control obaveznopolje">
                    <option></option>
                    <option value="1000">1000 km</option>
                    <option value="10000">10000 km</option>
                    <option value="25000">25000 km</option>
                    <option value="50000">50000 km</option>
                    <option value="75000">75000 km</option>
                    <option value="100000">100000 km</option>
                    <option value="125000">125000 km</option>
                    <option value="150000">150000 km</option>
                    <option value="200000">200000 km</option>
                    <option value="250000">250000 km</option>
                    <option value="300000">300000 km</option>
                  </select>
                </div>
              </div>
              {{-- polje za kilometrazu od --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm">
                  <label for="kildo" id="kildolabel" class="control-label text-info">Kilometraža do</label>
                  <select name="kildo" id="kildo" class="form-control obaveznopolje">
                    <option></option>
                    <option value="1000">1000 km</option>
                    <option value="10000">10000 km</option>
                    <option value="25000">25000 km</option>
                    <option value="50000">50000 km</option>
                    <option value="75000">75000 km</option>
                    <option value="100000">100000 km</option>
                    <option value="125000">125000 km</option>
                    <option value="150000">150000 km</option>
                    <option value="200000">200000 km</option>
                    <option value="250000">250000 km</option>
                    <option value="300000">300000 km</option>
                  </select>
                </div>
              </div>
              {{-- polje za pogon --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('pogon') ? ' has-error' : '' }}">
                  <label for="pog" id="poglabel" class="control-label text-info">Pogon</label>
                  <select name="pog" id="pog" class="form-control obaveznopolje">
                    <option></option>
                    <option value="p">Prednji</option>
                    <option value="z">Zadnji</option>
                    <option value="4x4">4x4</option>
                    <option value="4x4r">4x4 reduktor</option>
                  </select>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{-- polje za menjac --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('menjac') ? ' has-error' : '' }}">
                  <label for="menj" id="menjlabel" class="control-label text-info">Menjač</label>
                  <select name="menj" id="menj" class="form-control obaveznopolje">
                    <option></option>
                    <option value="m4">Manuelni 4 brzine</option>
                    <option value="m5">Manuelni 5 brzina</option>
                    <option value="m6">Manuelni 6 brzina</option>
                    <option value="pa">Poluautomatski</option>
                    <option value="a">Automatski</option>
                  </select>
                </div>
              </div>  
              {{-- polje za br vrata --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('brvrata') ? ' has-error' : '' }}">
                  <label for="brvr" id="brvrlabel" class="control-label text-info">Broj vrata</label>
                  <select name="brvr" id="brvr" class="form-control obaveznopolje">
                    <option></option>
                    <option value="3">2/3 vrata</option>
                    <option value="4">4/5 vrata</option>
                  </select>
                </div>
              </div>
              {{-- polje za br sedista --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('') ? ' has-error' : '' }}">
                  <label for="brsed" id="brsedlabel" class="control-label text-info">Broj sedišta</label>
                  <select name="brsed" id="brsed" class="form-control obaveznopolje">
                    <option></option>
                    <option value="2">2 Sedišta</option>
                    <option value="3">3 Sedišta</option>
                    <option value="4">4 Sedišta</option>
                    <option value="5">5 Sedišta</option>
                    <option value="6">6 Sedišta</option>
                    <option value="7">7 Sedišta</option>
                    <option value="8">8 Sedišta</option>
                    <option value="9">9 Sedišta</option>
                  </select>
                </div>
              </div>  
              {{-- polje za stranu volana --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('stranavolana') ? ' has-error' : '' }}">
                  <label for="strvol" id="strvollabel" class="control-label text-info">Strana volana</label>
                  <select name="strvol" id="strvol" class="form-control obaveznopolje">
                    <option></option>
                    <option value="l">Levi Volan</option>
                    <option value="d">Desni Volan</option>
                  </select>
                </div>
              </div>
              {{-- polje za klimu --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('klima') ? ' has-error' : '' }}">
                  <label for="kli" id="klilabel" class="control-label text-info">Klima</label>
                  <select name="kli" id="kli" class="form-control obaveznopolje">
                    <option></option>
                    <option value="0">Bez Klime</option>
                    <option value="mk">Manuelna Klima</option>
                    <option value="ak">Automatska Klima</option>
                  </select>
                </div>
              </div>
              {{-- polje za boju, obavezno --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('boja') ? ' has-error' : '' }}">
                  <label for="boja" id="bojalabel" class="control-label text-info">Boja</label>
                  <select name="boja" id="boja" class="form-control obaveznopolje">
                    <option></option>
                    <option value="bela">Bela</option>
                    <option value="bez">Bež</option>
                    <option value="bordo">Bordo</option>
                    <option value="braon">Braon</option>
                    <option value="crna">Crna</option>
                    <option value="crvena">Crvena</option>
                    <option value="kameleon">Kameleon</option>
                    <option value="ljubicasta">Ljubičasta</option>
                    <option value="narandzasta">Narandžasta</option>
                    <option value="plava">Plava</option>
                    <option value="siva">Siva</option>
                    <option value="srebrna">Srebrna</option>
                    <option value="tirkiz">Tirkiz</option>
                    <option value="teget">Teget</option>
                    <option value="zelena">Zelena</option>
                    <option value="zuta">Žuta</option>
                  </select>
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <div class="row">

              {{-- polje za poreklo --}}
              <div class="col-md-2">
                <div class="form-group form-group-sm {{ $errors->has('poreklo') ? ' has-error' : '' }}">
                  <label for="por" id="porlabel" class="control-label text-info">Poreklo</label>
                  <select name="por" id="por" class="form-control obaveznopolje">
                    <option></option>
                    <option value="dt">Domace tablice</option>
                    <option value="st">Strane tablice</option>
                    <option value="nik">Na ime kupca</option>
                  </select>
                  @if ($errors->has('poreklo'))
                    <span class="help-block">
                      <strong>{{ $errors->first('poreklo') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

            </div>{{--kraj diva row--}}

            <h4 class="frontformah4">Sigurnost</h4>

            <div class="row">

              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="airb" name="airb" value="airb"> Airbag
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="cloc" name="cloc" value="cloc"> Child lock
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="abs" name="abs" value="abs"> ABS
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="esp" name="esp" value="esp"> ESP
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="asr" name="asr" value="asr"> ASR
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="alrm" name="alrm" value="alrm"> Alarm
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
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="xen" name="xen" value="xen"> Xenon svetla
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="led" name="led" value="led"> LED svetla
                  </label>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-2 col-xs-6">
                <div class="form-group form-group-sm">
                  <label class="form-check-label text-info checkboxnovioglas">
                    <input class="form-check-input checkboxnovioglas" type="checkbox" id="koza" name="koza" value="koza"> Kožna sedišta
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
            {{-- submit btn --}}
            <div class="col-md-6">
              <div class="form-group form-group-sm">
                <input id="detaljna" name="detaljna" class="sabmint btn btn-block btn-info" value="Detaljna Pretraga">
              </div>
            </div>

          </div>

        </form>
      </div>{{--kraj diva .formapretraga--}}

      <div class="panel panel-primary">
        @if(Session::has('success')) 
          <div class="text-center success-message" role="alert">
            <strong>
              {!! Session::get('success') !!}
            </strong>
          </div>
        @endif 
        <div class="panel-heading">
          <p class="text-center">Najnoviji Oglasi</p>
        </div>

        <div class="panel-body paneloglasinaslovna">

          <div class="oglasipocetna">
            <div class="row">
              @foreach($oglasi as $oglas)
                <div class="col-md-6 jedanoglas">
                  <div class="col-md-5">
                    @if($oglas->slike != 0)
                      @php
                        for($i = 1; $i <= 12; $i++){
                          if(file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg")){
                            echo "<img src='".url('/')."/img/oglasi/".$oglas->folderslike."/".$oglas->id."/thumb".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='naslovnaslikapocetna'>";
                            break;
                          }
                        }
                      @endphp
                    @else
                      <img src="{{ asset("img/no_image_available1.jpg") }}" class="naslovnaslikapocetna">
                    @endif
                  </div> {{--kraj div-a .col-md-5--}}
                  <div class="col-md-7 divosnovnipodatcioglasanaslovna">
                    <div>
                      {{-- <b>{{ $oglas->naslov }}</b> --}}
                      <b>{{ $oglas->marka }}/{{ $oglas->model }}</b>
                      &nbsp; <span class="cenanaslovna pull-right">{{ $oglas->cena }} &euro;</span>
                      <p class="posnovnipodatcioglasanaslovna">
                        <small>Postavljen:{{ $oglas->created_at->format('d.m.Y.') }}</small><br>
                        {{-- <b>{{ $oglas->marka }}/{{ $oglas->model }}</b>|  --}}
                        <b>
                        <small class="small">
                          @if($oglas->gorivo == 'dizel')
                            Dizel
                          @elseif($oglas->gorivo == 'benzin')
                            Benzin
                          @elseif($oglas->gorivo == 'benzingas') 
                            Benzin+Gas
                          @elseif($oglas->gorivo == 'metan')
                            Metan CNG
                          @elseif($oglas->gorivo == 'elektricni')
                            Električni Pogon
                          @elseif($oglas->gorivo == 'hibrid')
                            Hibrid
                          @endif   
                        </small>  
                        </b>|<b><small class="small">{{ $oglas->godiste }} God.|{{ $oglas->kubikaza }} cm<sup>3</sup></small></b>
                        <br>
                        <b><small class="small">{{ $oglas->snagaks }}</b>KS/<b>{{ $oglas->snagakw }}</b>KW|<b>{{ $oglas->karoserija == 'hecbek' ? "hečbek" : $oglas->karoserija }} </small></b>
                        <br>
                        <small class="small">Kilometraža: <b>{{ $oglas->kilometraza }}</b> Km</small>     
                      </p>  
                    </div>         
                  </div>  
                </div>{{--kraj diva .jedanoglas--}}
              @endforeach

            <div class="divispodoglasa"></div>
            </div>{{--kraj diva row--}}
            
            {{-- ako je varijabla $ukupnooglasa(u njoj je ukupan br oglasa u 'oglasis' tablei) veca od 6 prikazujemo h1 koji sluzi kao btn
            za ucitavanje jos oglasa --}}
            {{-- <h1>{{$ukupnoolgasa}}</h1> --}}
            @if($ukupnoolgasa > 6)  
              <h3 class="text-center naslovjosoglasa shadow">Još Oglasa</h3>
            @endif 
          </div>{{--kraj diva .oglasipocetna--}}

        </div>{{-- kraj div-a .paneloglasinaslovna --}}
      </div>
    </div>
  </div>
{{-- </div> --}}

  <script type="text/javascript" src="{{ asset('js/autojq/welcome.js') }}"></script>
  <script type="text/javascript">
    var homeurl = '{{ url('/') }}';
    var josoglasaurl = '{{ route('josoglasa') }}';
    var ukupnooglasa = '{{ $ukupnoolgasa }}'; 
    var token = '{{ Session::token() }}';
    //ruta ka metodu izvadimodele FrontControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodelefront') }}'; 
  </script>
@endsection
