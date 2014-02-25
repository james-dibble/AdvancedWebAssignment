<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-info">
            <strong>Failed</strong> The generated XML does not conform to the schema at <a href="<?php echo SCHEMA_PATH; ?>" target="_blank"><?php echo SCHEMA_PATH; ?></a>.
            <br />
            <br />
            <strong>Validation Errors</strong>
            <ul>
                <?php
                foreach (libxml_get_errors() as $validationError)
                {
                    echo '<li>Line [' . $validationError->line . '] - ' . $validationError->message . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>