<form method="post">
    <div style="padding:2px 8px 7px 8px; 
         margin-bottom:20px; 
         background: #FFFFFF;
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25); 
         border: 1px solid #e8e8e8; 
         -moz-border-radius: 7px; 
         -khtml-border-radius: 7px; 
         -webkit-border-radius: 7px; 
         border-radius: 7px;">
        <center><h3>CodeIgniter Admin Pro INSTALLATION</h3></center>
        <p>Welcome to CodeIgniter Admin Pro.</p>
        <h4>Config folder</h4>
        <p>The config folder must be writable </p>
        <table>
            <tr>
                <td>Folder config: &nbsp; </td>
                <td><strong><?php echo __DATABASE_CONFIG_PATH__; ?></strong></td>
            </tr>
        </table>
        <h4>Database</h4>
        <p>Open config/database.php and change your mysql database server config.</p>
        <table>
            <tr>
                <td>Database Host: </td>
                <td><b><?php echo $this->db->hostname; ?></b></td>
            </tr>
            <tr>
                <td>User Name: </td>
                <td><b><?php echo $this->db->username; ?></b></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><b>******</b></td>
            </tr>
            <tr>
                <td>Database Name: &nbsp; </td>
                <td><b><?php echo $this->db->database; ?></b></td>
            </tr>
        </table>
        <h4>Data</h4>
        <label class="checkbox">
            <input type="hidden" value="0" id="sample_data" name="sample_data">
            <input type="checkbox" value="1" id="sample_data" name="sample_data" checked="checked"> Sample data
        </label>

       
        <?php if (count($errors) >0){ ?>
        <br/>
        <div class="alert alert-error">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <?php foreach ($errors as $v){ ?>
            <strong>Error!</strong> <?php echo $v; ?><br />
            <?php } ?>
        </div>
        <?php } ?>
        <input type="submit" class="btn btn-large btn-success" value="Installation V1.0" />


        <hr />
        <footer>
            <p><?php echo $this->lang->line('copyright_company'); ?></p>
        </footer>
    </div>
</form>