<p class="lead">Or using a plain text import into this text box:</p>
<form class="form-inline" role="form" method="POST" action="<?php echo CONTEXT_PATH; ?>import/text">
    <label>File Contents</label>
    <textarea class="form-control" rows="10" name="inputContents"></textarea>
    <br /><br />
    <button type="submit" class="btn btn-primary btn-block">Import</button>
</form>