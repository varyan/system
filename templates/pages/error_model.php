<style>
    body,html{
        padding: 0;
        margin: 0;
        background: lightgray;
    }
    .page-heading{
        width: 100%;
        height: 50px;
        background: #333;
        color: #fff;
    }
    .page-heading > h3{
        padding: 12px;
        color: brown;
    }
    .error-message{
        padding: 20px;
        font-size: 18px;
    }
</style>
<div class="page-heading">
    <h3>Error : model</h3>
</div>
<p class="error-message">
    <?=$message?>
</p>