<fieldset>
    <!-- Form Name -->
    <legend>Add new task</legend>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">Employee name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <select name="spnEmp" id="spnEmp" class="form-control">
                    <option value="#">Select</option>   
                    <?php
                    $SQL = "select * from admin_accounts";
                    $query = $db->query($SQL);

                    foreach ($query as $row1) {
                        ?>
                        <option value='<?php echo $row1['id']; ?> '>
                            <?php echo $row1['fname'] . ' ' . $row1['lname']; ?>  </option>  
                    <?php }
                    ?>

                </select>
            </div>
        </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" >Customer name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-new-window"></i></span>
                <select name="cust_id" id="cust_id" class="form-control">
                    <option value="#">Select</option>   
                    <?php
                    $SQL = "select * from customers";
                    $query = $db->query($SQL);

                    foreach ($query as $row1) {
                        ?>
                        <option value='<?php echo $row1['id']; ?> '>
                            <?php echo $row1['f_name'] . ' ' . $row1['l_name']; ?>  </option>  
                    <?php }
                    ?>

                </select>
            </div>
        </div>
    </div>
    <!-- Add Task Desc -->
     <div class="form-group">
        <label class="col-md-4 control-label">Task Detail</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span align="top" class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                 <textarea name="taskdesc" id="taskdesc" placeholder="Add Task Description" class="form-control" id="address"></textarea>
            </div>
        </div>
    </div>
   
    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>