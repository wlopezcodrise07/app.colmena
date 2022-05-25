@if($metricas_influencer->metricas == "")
<ul class="nav nav-tabs">
  <?php $item = 1; ?>
  @foreach ($metricas_form as $key)
  <li class="nav-item">
    <a class="nav-link <?php echo ($item == 1) ? 'active' : $item ; ?>" data-bs-toggle="tab" href="#{{$key->red_social}}">{{mb_strtoupper($key->red_social,'UTF-8')}}</a>
  </li>
  <?php $item ++; ?>
  @endforeach
</ul>
<!-- Tab panes -->
<div class="tab-content">
  <?php $item = 1; ?>
  @foreach ($metricas_form as $key)
  <div class="tab-pane container <?php echo ($item == 1) ? 'active' : $item ; ?>" id="{{$key->red_social}}"><br>
    <div class="row">
      <center><h3>GENERAL</h3></center>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='general' and $key1->type_input!='array'): ?>
            <div class="col-md-4 <?php echo ($key1->type_input=='array')?'d-none':''  ?>">
              <label for="" style="font-size:8pt">{{$key1->descripcion}}  </label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}"  min="1" max="100" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control form-control-sm" name="{{$key1->input}}" rows="3" readonly></textarea>
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control form-control-sm er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="text" class="form-control form-control-sm castigo" name="{{$key1->input}}" min="0" max="100" value="100" readonly>
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><hr>
    <div class="row">
      <center><h3>METRICAS</h3></center>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='metrica' or $key1->valor=='metricas'): ?>
          <div class="col-md-6 <?php echo ($key1->type_input=='array' or $key1->type_input=='castigo')?'d-none':''  ?>">
            <label for="" style="font-size:8pt">{{$key1->descripcion}} <?php echo ($key1->type_input=='er') ? '<span class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$key1->tooltip.'"><i class="fas fa-info-circle"></i></span>' : '' ; ?></label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" min="1" max="100" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control form-control-sm" name="{{$key1->input}}" readonly>
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control form-control-sm" name="{{$key1->input}}" rows="3" readonly></textarea>
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control form-control-sm er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="text" class="form-control form-control-sm castigo" name="{{$key1->input}}" min="0" max="100" value="100" readonly>
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><hr>
    <div class="row">
      <center><h3>MÉTRICAS DEMOGRÁFICAS</h3></center>
      <div class="col-md-6">
        <div class="row">
          <h4 for="">METRICAS HOMBRE</h4>
          <br>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "sexo_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Edad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "edad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por País</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "pais_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Ciudad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "ciudad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <h4 for="">METRICAS MUJER</h4>
          <br>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "sexo_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Edad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "edad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por País</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "pais_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Ciudad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "ciudad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
        </div>
      </div>
    </div><hr>
  </div>
  <?php $item ++; ?>
  @endforeach
</div>

@else
<ul class="nav nav-tabs">
  <?php $item = 1; ?>
  @foreach ($metricas_form as $key)
  <li class="nav-item">
    <a class="nav-link <?php echo ($item == 1) ? 'active' : $item ; ?>" data-bs-toggle="tab" href="#{{$key->red_social}}">{{mb_strtoupper($key->red_social,'UTF-8')}}</a>
  </li>
  <?php $item ++; ?>
  @endforeach
</ul>
<!-- Tab panes -->
<div class="tab-content">
  <?php $item = 1; ?>
  <?php $item = 1; ?>
  @foreach ($metricas_form as $key)
  <div class="tab-pane container <?php echo ($item == 1) ? 'active' : $item ; ?>" id="{{$key->red_social}}"><br>
    <div class="row">
      <center><h3>GENERAL</h3></center>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='general' and $key1->type_input!='array'): ?>
            <div class="col-md-4 <?php echo ($key1->type_input=='array')?'d-none':''  ?>">
              <label for="" style="font-size:8pt">{{$key1->descripcion}}  </label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" min="1" max="100" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control form-control-sm" name="{{$key1->input}}" rows="3" readonly></textarea>
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control form-control-sm er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="text" class="form-control form-control-sm castigo" name="{{$key1->input}}" min="0" max="100" value="100" readonly>
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><hr>
    <div class="row">
      <center><h3>METRICAS</h3></center>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='metrica' or $key1->valor=='metricas'): ?>
          <div class="col-md-6 <?php echo ($key1->type_input=='array' or $key1->type_input=='castigo')?'d-none':''  ?>">
            <label for="" style="font-size:8pt">{{$key1->descripcion}} <?php echo ($key1->type_input=='er') ? '<span class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$key1->tooltip.'"><i class="fas fa-info-circle"></i></span>' : '' ; ?></label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control form-control-sm" name="{{$key1->input}}" min="1" max="100" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control form-control-sm" name="{{$key1->input}}" rows="3" readonly></textarea>
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control form-control-sm er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control form-control-sm castigo" name="{{$key1->input}}" min="0" max="100" value="100"  readonly>
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><hr>
    <div class="row">
      <center><h3>MÉTRICAS DEMOGRÁFICAS</h3></center>
      <div class="col-md-6">
        <div class="row">
          <h4 for="">METRICAS HOMBRE</h4>
          <br>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "sexo_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Edad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "edad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por País</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "pais_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Ciudad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "hombres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "ciudad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-6" style="border-left:1px solid #69707a">
        <div class="row">
          <h4 for="">METRICAS MUJER</h4>
          <br>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "sexo_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Edad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "edad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por País</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "pais_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?><br>
            <p for="">Distribución por Ciudad</p>
            <?php foreach (json_decode($key->json_demografica) as $key1): ?>
              <?php if (strpos($key1->input, "mujeres") !== false): ?>
                <?php if (strpos($key1->input, "sexo_") !== false) {
                  $col = 12;
                }elseif (strpos($key1->input, "edad_") !== false) {
                  $col = 4;
                }elseif (strpos($key1->input, "pais_") !== false) {
                  $col = 6;
                }elseif (strpos($key1->input, "ciudad_") !== false) {
                  $col = 6;
                } ?>
                <?php if (strpos($key1->input, "ciudad_") !== false): ?>
                  <div class="col-md-<?php echo $col ?>">
                    <label for="" style="font-size:8pt">{{$key1->descripcion}} </label>
                    <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
                      <input type="text" class="form-control form-control-sm" name="{{$key1->input}}" value="" readonly>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
        </div>
      </div>
    </div><hr>
  </div>
  <?php $item ++; ?>
  @endforeach
</div>
<script type="text/javascript">
  var metricasEdit = JSON.parse("{{$metricas_influencer->metricas}}".replace(/&quot;/g,'"'))
  metricasEdit.forEach(element => (element[0].metricas).forEach( val =>
    $('#'+element[0].red_social).find('[name='+val.input+']').val(val.valor)
  )
);
activate_tooltip()

</script>
@endif
<script type="text/javascript">
  $('input[name=seguidores]').addClass('seguidores')
</script>
