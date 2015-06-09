  <style type="text/css">
    @import url(http://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300);

    .feed{
      padding-top: 20px;
      margin-left: 85px;
    }
    .feed-item{
      display: block;
      width: 100%;
      height: 130px;
      margin-bottom: 10px;
      background: white;
      padding-left: -100px;
      box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
      transition:  0.7s;
      
    }
    .feed-comment{
      display: block;
      width: 100%;
      margin-top: -12px;
      padding: 0px 60px;
      background: white;
      padding-left: -100px;
      box-shadow: 0px 2px 2px rgba(0,0,0,0.2);
      transition:  0.7s;
      
    }
    .feed-comment .icon-holder{
      width: 55px;
      float: left;
      margin: 21px 20px 0 25px;
    }
    .feed-comment .icon-holder .icon{
      width: 55px;
      height: 55px;
      border-radius: 100%;
      float: left;
      background-image: url('assets/images/!logged-user.jpg');
      background-size: 55px 55px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    .feed-comment .text-holder{
      margin-top: 22px;
      width: 75%;
      float: left;
    }
    .feed-comment .spacer{
      width: 10%;
      float: left;
    }
    .feed-item .icon-holder{
      width: 55px;
      float: left;
      margin: 21px 20px 0 25px;
    }
    .feed-item .icon-holder .icon{
      width: 55px;
      height: 55px;
      border-radius: 100%;
      float: left;
      background-image: url('assets/images/!logged-user.jpg');
      background-size: 55px 55px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    .image-comment {
      width: 40px;
      height: 40px;
      border-radius: 20px;
      -webkit-border-radius: 20px;
      -moz-border-radius: 20px;
      background-color: #888; 
      }
    .feed-item .text-holder{
      margin-top: 22px;
      width: 75%;
      float: left;
    }
    .feed-item .spacer{
      width: 10%;
      float: left;
    }
    .feed-description{
      font-size: 1em;
      font-weight: 400;
      color: #888;
      height: 3.5em;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .post-options-holder{
      float: right;
      height: 100%;
      width: 30px;
      background: #FFCDD2;
      padding: 12px;
      transition: background 0.2s;
    }
    .post-options-holder:hover{
      background: #D32F2F;
    }
    .feed-title{
      font-size: 1.1em;
      font-weight: 500;
    }
    .feed-like{
      font-size: .9em;
      font-weight: 400;
      color: #2196F3;
    }
    .blog{
      overflow: hidden;
    }
    .portfolio{
      overflow: hidden;
    }
    button.pull-right {
      margin-right: 40px;
    }
    textarea {
      text-align: left;
      display: block;
      margin: 0 auto;
      width: 90%;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      margin-bottom: 20px;
      -webkit-appearance: none;
      border:1px solid #D3D3D3;
      box-shadow: none;
    }





    /*END FORM*/


    @media all and (max-width: 560px){.feed-item .feed-comment .text-holder{width: 70%}}
    @media all and (max-width: 470px){
    @import url(http://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300);

    .feed{
      padding-top: 20px;
      margin-left: 85px;
    }
    .feed-item{
      display: block;
      width: 100%;
      height: 100px;
      margin-bottom: 10px;
      background: white;
      padding-left: -100px;
      box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
      transition:  0.7s;
      
    }
    .feed-item .icon-holder{
      width: 55px;
      float: left;
      margin: 21px 20px 0 25px;
    }
    .feed-item .icon-holder .icon{
      width: 55px;
      height: 55px;
      border-radius: 100%;
      float: left;
      background-image: url('assets/images/!logged-user.jpg');
      background-size: 55px 55px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    .feed-item .text-holder{
      margin-top: 22px;
      width: 75%;
      float: left;
    }
    .feed-item .spacer{
      width: 10%;
      float: left;
    }
    .feed-description{
      font-size: .9em;
      font-weight: 300;
      color: #888;
      height: 2.4em;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .image-comment {
      display: none;
      }
    .post-options-holder{
      float: right;
      height: 100%;
      width: 30px;
      background: #FFCDD2;
      padding: 12px;
      transition: background 0.2s;
    }
    .post-options-holder:hover{
      background: #D32F2F;
    }
    .feed-title{
      font-size: .9em;
      font-weight: 500;
    }
    button.pull-right {
      margin-right: 10px;
    }
    .blog{
      overflow: hidden;
    }
    .portfolio{
      overflow: hidden;
    }
    .feed-item .text-holder{width: 50%}
    }
  }
    
  </style>
    <script type="text/javascript">
    //var suka = 0;
    function suka(){
        //suka += 1;
        //$.post("submit.php", { like: suka},
        document.getElementById("coba").innerHTML = "<a href='#' class='like' id='like' onclick='gasuka()'><i class='fa fa-thumbs-o-down'></i> Unlike</a> <a href='#' data-toggle='collapse' data-target='#demo'><i style='margin-left: 15px;'' class='fa fa-comments'></i> Comment</a>";
                        };
    function gasuka(){
        document.getElementById("coba").innerHTML = "<a href='#' class='like' id='like' onclick='suka()'><i class='fa fa-thumbs-o-up'></i> Like</a> <a href='#' data-toggle='collapse' data-target='#demo'><i style='margin-left: 15px;' class='fa fa-comments'></i> Comment</a>";
    }
    </script>

        <div class="feed-item blog">
          <div class="icon-holder"><div class="icon"></div></div>
          <div class="text-holder">
            <div class="feed-title">Blog Item</div>
            <div class="feed-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia natus obcaecati consequuntur quis molestias! Minima impedit ad omnis. Libero quibusdam facere dignissimos ut mollitia unde sunt nobis quia, nam quasi!
            </div>
          </div><!--End of Text Holder-->
        </div><!--End of Feed Item-->

        <div class="feed-item blog">
          <div class="icon-holder"><div class="icon"></div></div>
          <div class="text-holder">
            <div class="feed-title">John Doe</div>
            <div class="feed-description">Has Convert Leads "My Leads" to Account</div>
            <div class="feed-like"><i class="fa fa-thumbs-o-up"></i> Like <i style="margin-left: 15px;" class="fa fa-comments"></i> Comment</div>
          </div><!--End of Text Holder-->
          
        </div><!--End of Feed Item-->
        

         <div class="feed-item blog">
          <div class="icon-holder"><div class="icon"></div></div>
          <div class="text-holder">
            <div class="feed-title">John Doe</div>
            <div class="feed-description">Andal CRM is awesome!</div>
            <div id="coba" class="feed-like"><a href="#" class="like" id="like" onclick="suka()"><i class="fa fa-thumbs-o-up"></i> Like</a> 
            <a href="#" data-toggle="collapse" data-target="#demo"><i style="margin-left: 15px;" class="fa fa-comments"></i> Comment (2)</a></div>
          </div><!--End of Text Holder-->
          
        </div><!--End of Feed Item-->
        <div id="demo" class="collapse">
          <div class="feed-comment blog">
          <div class="icon-holder"><img class="image-comment" src="assets/images/!logged-user.jpg"></div>
          <div class="text-holder">
            <div class="feed-title">John Doe</div>
            <div class="feed-description">Yes!</div>
            
          </div><!--End of Text Holder-->
          
        </div><!--End of Feed Item-->
        <div class="feed-comment blog">
          <div class="icon-holder"><img class="image-comment" src="assets/images/!logged-user.jpg"></div>
          <div class="text-holder">
            <div class="feed-title">John Doe</div>
            <div class="feed-description">:)</div>
            
          </div><!--End of Text Holder-->
          
        </div>
          <div class="feed-comment blog">
            <textarea placeholder="write your comment here"></textarea> <button type="submit" class="pull-right btn btn-default">Send</button>
        </div>
        