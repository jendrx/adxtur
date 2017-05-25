<style>
    .form_bg {
        background-color:#eee;
        color:#666;
        padding:10px;
        border-radius:10px;
        position: absolute;
        border:1px solid #fff;
        margin: auto;
        top: 0;
        right:0;
        bottom: 280px;
        left: 0;
        width: 320px;
        height: 280px;
    }
    .align-center {
        text-align:center;
    }
</style>
<div class="container">
    <div class="row">
        <div class="form_bg col-md-12"> <!-- remove form-bg class-->
            <?= $this->Form->create() ?>
            <h2 class="text-center">Login Page</h2>
            <br/>
            <div class="form-group">
                <?= $this->Form->control('username', ['class' => 'form-control']) ?>
                <!--<input type="email" class="form-control" id="userid" placeholder="User id">-->
            </div>
            <div class="form-group">
                <?= $this->Form->control('password', ['class' => 'form-control']) ?>
                <!--<input type="password" class="form-control" id="pwd" placeholder="Password">-->
            </div>
            <br/>
            <div class="align-center">
                <?= $this->Form->button(__('Login'), ['class' => ['btn', 'btn-default']]); ?>
                <?= $this->Form->end() ?>
                <!--<button type="submit" class="btn btn-default" id="login">Login</button>-->
            </div>
        </div>
    </div>
</div>