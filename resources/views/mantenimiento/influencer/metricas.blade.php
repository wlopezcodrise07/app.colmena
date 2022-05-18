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
      <h1>GENERAL</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='general'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><br>
    <div class="row">
      <h1>METRICAS</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='metrica' or $key1->valor=='metricas'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><br>
    <div class="row">
      <h1>MÉTRICAS DEMOGRÁFICAS</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='demo_sexo' or $key1->valor=='demo_edad'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><br>
    <div class="row">
      <h1>TARIFAS</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='tarifario'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
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
      <h1>GENERAL</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='general'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><br>
    <div class="row">
      <h1>METRICAS</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='metrica' or $key1->valor=='metricas'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><br>
    <div class="row">
      <h1>MÉTRICAS DEMOGRÁFICAS</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='demo_sexo' or $key1->valor=='demo_edad'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div><br>
    <div class="row">
      <h1>TARIFAS</h1>
      <?php foreach (json_decode($key->json) as $key1): ?>
        <?php if ($key1->valor=='tarifario'): ?>
          <div class="col-md-3">
            <label for="">{{$key1->descripcion}}</label>
            <?php if ($key1->type_input=='text' or $key1->type_input=='number'): ?>
              <input type="{{$key1->type_input}}" class="form-control" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='promedio'): ?>
              <input type="number" class="form-control" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='moneda'): ?>
              <select class="form-control" name="{{$key1->input}}">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
              </select>
            <?php elseif($key1->type_input=='textarea'): ?>
              <textarea class="form-control" name="{{$key1->input}}" rows="3" ></textarea>
            <?php elseif($key1->type_input=='array'): ?>
              <input type="text" class="form-control array_prom" name="{{$key1->input}}" value="">
            <?php elseif($key1->type_input=='er'): ?>
              <input type="text" class="form-control er" name="{{$key1->input}}" value="" readonly>
            <?php elseif($key1->type_input=='castigo'): ?>
              <input type="number" class="form-control castigo" name="{{$key1->input}}" min="0" max="100" value="100" >
          <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <?php $item ++; ?>
  @endforeach
</div>
<script type="text/javascript">
  var metricasEdit = JSON.parse("{{$metricas_influencer->metricas}}".replace(/&quot;/g,'"'))
  metricasEdit.forEach(element => (element[0].metricas).forEach( val =>
    $('#'+element[0].red_social).find('[name='+val.input+']').val(val.value)
  )
);
actualizarMetrica()

</script>
@endif
<script type="text/javascript">
  $('input[name=seguidores]').addClass('seguidores')
</script>
