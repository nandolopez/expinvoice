<div class="panel panel-primary">
  <div class="panel-heading">
      Exportar Excel para timón
  </div>
  <div class="panel-body">
  <div class="col-sm-4 col-sm-push-4 col-sm-pull-4">
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
          <label for="inicio" class="control-label">Facturas desde:</label>
          <div class="input-group date">
            <input type="text" name="inicio" class="fecha form-control" value="{$smarty.now|date_format:"%Y/%m/%d"}">
            <span class="input-group-addon"><i class="icon-calendar clinicio" for="inicio"></i></span>
          </div>
        </div>
        <label for="fin" class="control-label">Hasta:</label>
        <div class="form-group">
          <div class="input-group date">
            <input type="text" name="fin"  class="fecha form-control" value="{$smarty.now|date_format:"%Y/%m/%d"}">
            <span class="input-group-addon"><i class="icon-calendar clfin" for="inicio"></i></span>
          </div>
        </div>
        <div class="formg-group">
          <div class="input-group">
            <input type="submit" name="" value="Verificar" class="btn btn-primary btn-lg">
          </div>
        </div>
      </form>
      </div>
  </div>
</div>
