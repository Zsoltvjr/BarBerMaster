<?php include('includes/header.php');      ?>

<div class="row">
    <div class="col-md-12">
        <div class ="card">
                <div class = "card-header">
                    <h4>
                    Szalon tulajdonos törlése
                      <a href = "users.php" class="btn btn-danger float-end">Vissza</a>
                     </h4>
                </div>  
         <div class="card-body">
                        <form action ="delete.php" method="post" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-md-3">
                                <div class="mb-3">
                                <label>Név</label> 
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                                </div>
                                <div class="col-md-3">
                                <div class="mb-3">
                                <label>Jelszó</label> 
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                                </div>
                                <div class="col-md-3">
                                <div class="mb-3">
                                <label>Fodrászszalon</label> 
                             <select name="ownerid" class="form-select" required>
                                   <option value="" disabled selected>Válaszd ki a Fodrászszalont</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>    
                             </select>
                            </div>
                                </div>
                                <div class="mb-3">
                                <button type="submit" name="SaveUser" class="btn btn-primary">Mentés</button>
                            </div>

                        </form>
         </div>       
        </div>        
    </div>
</div>

<?php include('includes/footer.php');      ?>