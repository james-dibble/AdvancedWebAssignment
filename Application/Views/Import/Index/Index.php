<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-danger">
            <strong>Warning!</strong>&nbsp;Importing a file will delete all current crime entries.
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h2>Data Import</h2>
        <p>
            Crime records can be imported using a direct export of the <code>.xlsx</code> file to 
            <code>.csv</code> such as <a href="<?php echo CONTEXT_PATH; ?>crimeRecord.csv">this Example File</a>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php include 'ImportForm.php'; ?>
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
    <div class="col-lg-12">
        <?php include 'ImportFromText.php'; ?>
    </div>
</div>
<div class="row">&nbsp;</div>