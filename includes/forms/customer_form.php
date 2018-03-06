<fieldset>
    <div class="form-group">
        <label for="f_name">First Name *</label>
          <input type="text" name="f_name" value="<?php echo $edit ? $customer['f_name'] : ''; ?>"
                 placeholder="First Name" class="form-control" required="required" id = "f_name" >
    </div> 

    <div class="form-group">
        <label for="l_name">Last name *</label>
        <input type="text" name="l_name" value="<?php echo $edit ? $customer['l_name'] : ''; ?>" placeholder="Last Name" class="form-control" required="required" id="l_name">
    </div> 

    <div class="form-group" style="display: none">
        <label>Gender * </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="male" <?php echo ($edit &&$customer['gender'] =='male') ? "checked": "" ; ?> required="required"/> Male
        </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="female" <?php echo ($edit && $customer['gender'] =='female')? "checked": "" ; ?> required="required" id="female"/> Female
        </label>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
          <textarea name="address" placeholder="Address" class="form-control" id="address"><?php echo ($edit)? $customer['address'] : ''; ?></textarea>
    </div> 
    <!-- Add Location -->
   <div id="container">
  <div class="form-group">
    <label for="location">Location* : </label>
    <input type="text" name="location" id="location" class="form-control" placeholder="Enter Address" required="required">
  </div>
  <div class="geo-details">
    <table class="table">
      <tr>
        <td align="left">Country</td>
        <td><input readonly="true" align="left" type="text" data-geo="country" value="" 
                   id="setting_country" name="setting_country" class="form-control">
        </td>
      </tr>
      <tr style="display: none">
        <td align="left">Country code</td>
        <td><input align="left" readonly="true" type="text" data-geo="country_short" value="" 
                   id="setting_country_short" name="setting_country_short" class="form-control">
        </td>
      </tr>
      <tr>
        <td align="left">State</td>
        <td><input readonly="true" type="text" data-geo="administrative_area_level_1" 
                   value="" id="setting_state" name="setting_state" class="form-control">
        </td>
      </tr>
      <tr style="display: none">
        <td align="left">State code</td>
        <td><input align="left" readonly="true" type="text" data-geo="administrative_area_level_1_short"
                   value="" id="setting_state_short" name="setting_state_short" class="form-control">
        </td>
      </tr>
      <tr>
        <td align="left">City</td>
        <td><input readonly="true" type="text" data-geo="administrative_area_level_2" 
                   value="" id="setting_city" name="setting_city" class="form-control">
        </td>
      </tr>
      <tr style="display: none">
        <td align="left">Latitude</td>
        <td><input align="left" readonly="true" type="text" data-geo="lat" value="" id="setting_latitude" 
                   name="setting_latitude" class="form-control">
        </td>
      </tr>
      <tr style="display: none">
        <td align="left">Longitude</td>
        <td><input align="left" readonly="true" type="text" data-geo="lng" value="" id="setting_longitude" 
                   name="setting_longitude" class="form-control">
        </td>
      </tr>
    </table>
  </div>
   </div>
    <!--end Add Location -->
    
    <div class="form-group" style="display: none">
        <label>State </label>
           <?php $opt_arr = array("Maharashtra", "Kerala", "Madhya pradesh"); 
                            ?>
            <select name="state" class="form-control selectpicker" required>
                <option value=" " >Please select your state</option>
                <?php
                foreach ($opt_arr as $opt) {
                    if ($edit && $opt == $customer['state']) {
                        $sel = "selected";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                }

                ?>
            </select>
    </div>  
    <div class="form-group">
        <label for="email">Email</label>
            <input  type="email" name="email" value="<?php echo $edit ? $customer['email'] : ''; ?>" placeholder="E-Mail Address" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
            <input name="phone" value="<?php echo $edit ? $customer['phone'] : ''; ?>" placeholder="987654321" class="form-control"  type="text" id="phone">
    </div> 

    <div class="form-group">
        <label>Date of birth</label>
        <input name="date_of_birth" value="<?php echo $edit ? $customer['date_of_birth'] : ''; ?>"  placeholder="Birth date" class="form-control"  type="date">
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>