<form class="form-inline" role="form" method="POST" action="<?php echo CONTEXT_PATH; ?>import/file" enctype="multipart/form-data">
  <div class="form-group">
    <label class="sr-only">CSV File</label>
    <input type="file" class="form-control" name="inputCsvFile" />
  </div>
  <button type="submit" class="btn btn-primary">Import</button>
</form>