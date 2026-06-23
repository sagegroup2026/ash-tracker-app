<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
 <style>
            .news-card{
                background:#fff;
                border-radius:22px;
                overflow:hidden;
                box-shadow:0 4px 18px rgba(0,0,0,0.08);
                margin-bottom:18px;
                border:1px solid #f1f1f1;
            }
            
            .news-media{
                position:relative;
                width:100%;
                background:#f5f5f5;
                overflow:hidden;
            }
            
            .news-media img{
                width:100%;
                height:100%;
                object-fit:cover;
            }
            
            .file-preview{
                width:100%;
                height:100%;
                display:flex;
                align-items:center;
                justify-content:center;
                flex-direction:column;
                background:linear-gradient(135deg, #DBF3FA, #7AD7F0);
                
                color:#fff;
            }
            
            .file-preview i{
                font-size:70px;
                margin-bottom:10px;
            }
            
            .open-file-btn{
                background:#fff;
                color:#000;
                margin-bottom: 10px;
                border:none;
                padding:8px 18px;
                border-radius:30px;
                font-size:13px;
                font-weight:600;
            }
            
            .news-content{
                padding:14px;
            }
            
            /*.vertical-badge{*/
            /*    display:inline-block;*/
            /*    background: var(--yellow);*/
            /*    color: var(--tb-white);*/
            /*    font-size:11px;*/
            /*    font-weight:600;*/
            /*    padding:5px 12px;*/
            /*    border-radius:30px;*/
            /*    margin-bottom:10px;*/
            /*}*/
            
            .vertical-badge{
                position:absolute;
                top:12px;
                left:12px;
                z-index:2;
            
                background:linear-gradient(135deg,#6ea8fe,#c43cff);
                backdrop-filter:blur(6px);
            
                color:#fff;
                font-size:11px;
                font-weight:600;
            
                padding:6px 14px;
                border-radius:30px;
            
                letter-spacing:0.3px;
            }
            
            .news-header{
                display:flex;
                align-items:flex-start;
                justify-content:space-between;
                gap:10px;
            }
            
            .fav-btn{
    position:relative;

    min-width:42px;
    width:42px;
    height:42px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:50%;

    cursor:pointer;

    transition:0.25s ease;
}

.fav-btn i{
    font-size:24px;
    color:#777;

    transition:0.25s ease;
}

.fav-btn.active i{
    color:#ff3040;
}

.fav-btn.animate i{
    animation:heartPop 0.45s ease;
}

@keyframes heartPop{

    0%{
        transform:scale(0.5);
    }

    50%{
        transform:scale(1.35);
    }

    100%{
        transform:scale(1);
    }
}


/* BLAST EFFECT */

.heart-animation{
    position:absolute;
    width:100%;
    height:100%;
    border-radius:50%;
    pointer-events:none;
}

.fav-btn.animate .heart-animation{

    animation:blast 0.5s ease;
}

@keyframes blast{

    0%{
        box-shadow:
        0 0 0 0 rgba(255,48,64,0.6);
    }

    100%{
        box-shadow:
        0 0 0 18px rgba(255,48,64,0);
    }
}
            
            .news-title{
                font-size:15px;
                font-weight:700;
                margin-bottom:8px;
                color:#111;
            }
            
            .news-text{
                font-size:13px;
                color:#666;
                line-height:1.6;
            }
            
            .read-more{
                color:#0d6efd;
                font-weight:600;
                cursor:pointer;
                font-size:13px;
            }
            
            /*.custom-feed{*/
            /*    padding-bottom:80px;*/
            /*}*/
            
            .buzz-title{
                text-align:center;
                margin-bottom:18px;
            }
            
            .buzz-tabs{
                gap:10px;
            }
            
            .buzz-tabs .nav-link{
                border:none;
                border-radius:30px;
                padding:10px 18px;
                font-size:13px;
                font-weight:600;
                color:#666;
                background:#f3f4f6;
            }
            
            .buzz-tabs .nav-link.active{
                background:var(--blue);
                color:#fff;
            }
            .category-tabs{
                flex-wrap:nowrap;
                overflow:auto;
                gap:10px;
                padding-bottom:6px;
            }
            
            .category-tabs::-webkit-scrollbar{
                display:none;
            }
            
            .category-tabs .nav-link{
                white-space:nowrap;
                border:none;
                border-radius:30px;
                padding:8px 16px;
                background:#f4f4f4;
                color:#555;
                font-size:12px;
                font-weight:600;
            }
            
            .category-tabs .nav-link.active{
                background:linear-gradient(135deg,#6ea8fe,#c43cff);
                color:#fff;
            }
            @media(max-width:576px){
            
                .news-media{
                    /*height:230px;*/
                }
            
                .news-title{
                    font-size:14px;
                }
            
            }
        </style>
 <?php

$category = $this->input->get('category');

if(empty($category)){
    $category = 'all';
}

$latest_update = getUpdates($category);

?>      
<div class="main-div">
    <div class="profile-wrapper">
       
        <!--<div class="buzz-header">-->

        <!--    <h4 class="buzz-title ">Organization Feed</h4>-->

        <!--</div>-->
        
        <!--<hr>-->

        <!-- MAIN TABS -->
        <ul class="nav nav-pills buzz-tabs mb-3 d-flex align-items-center justify-content-center" id="mainTabs">

            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#latestBuzz">
                    Recent Highlights
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#favouritesBuzz">
                My Picks
                </button>
            </li>

        </ul>
        <div class="tab-content">
        <!-- LATEST BUZZ -->
        <div class="tab-pane fade show active" id="latestBuzz">

            <ul class="nav nav-pills category-tabs mb-3">
                <li class="nav-item">
                    <a href="?category=all"
                       class="nav-link <?= ($category=='all') ? 'active' : '' ?>">
                        All
                    </a>
                </li>
            
                <li class="nav-item">
                    <a href="?category=education"
                       class="nav-link <?= ($category=='education') ? 'active' : '' ?>">
                        Education
                    </a>
                </li>
            
                <li class="nav-item">
                    <a href="?category=healthcare"
                       class="nav-link <?= ($category=='healthcare') ? 'active' : '' ?>">
                        Healthcare
                    </a>
                </li>
            
                <li class="nav-item">
                    <a href="?category=realstate"
                       class="nav-link <?= ($category=='realstate') ? 'active' : '' ?>">
                        Realstate
                    </a>
                </li>
            
            </ul>
            <div class="custom-feed" data-category="<?= strtolower($g->vertical) ?>">

                <?php
// $latest_update = getUpdates($login_id); 

if(!empty($latest_update)){
foreach($latest_update as $g){

$file = "https://admin.apollosage.in/ash-tracker-admin/uploads/latest_updates/".$g->text_file;
$ext  = pathinfo($g->text_file, PATHINFO_EXTENSION);
?>

                    <div class="news-card">

                        <!-- MEDIA -->
                        <div class="news-media">
                            <!-- BADGE -->
                            <span class="vertical-badge">
                                <?= $g->vertical ?>
                            </span>
                            <?php if($g->type == 'file'){ ?>

                                <?php if(in_array(strtolower($ext),['jpg','jpeg','png','webp'])){ ?>

                                    <img src="<?= $file ?>">

                                    <?php } else if(strtolower($ext) == 'pdf'){ ?>

                                        <div class="file-preview">
                                            <i class="ri-file-pdf-2-fill"></i>

                                            <button class="open-file-btn viewBtn" data-type="pdf" data-file="<?= $file ?>">
                                                Read PDF
                                            </button>
                                        </div>

                                        <?php } else { ?>

                                            <div class="file-preview">
                                                <i class="ri-file-word-2-fill"></i>

                                                <button class="open-file-btn viewBtn" data-type="doc" data-file="<?= $file ?>">
                                                    Open File
                                                </button>
                                            </div>

                                            <?php } ?>

                                                <?php } else { ?>

                                                    <!-- TEXT TYPE -->
                                                    <div class="file-preview">
                                                        <i class="ri-article-fill"></i>
                                                    </div>

                                                    <?php } ?>

                        </div>

                        <!-- CONTENT -->
                        <div class="news-content">

                            <div class="news-header">

                                <div class="news-title">
                                    <?= ucwords($g->title); ?>
                                </div>

                                <div class="fav-btn <?= isFavourite($g->id) ? 'active' : '' ?>"
                                     data-id="<?= $g->id ?>">
                                
                                    <i class="bi <?= isFavourite($g->id) ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                                
                                    <span class="heart-animation"></span>
                                
                                </div>

                            </div>

                            <?php if($g->type == 'text'){ ?>

                                <?php  $text = strip_tags($g->text_file); $short = substr($text,0,120); ?>

                                    <div class="news-text">

                                        <span class="short-text">
                                            <?= $short ?>
                                        </span>

                                        <?php if(strlen($text) > 120){ ?>

                                            <span class="more-text d-none">
                    <?= substr($text,120) ?>
                </span>

                                            <span class="read-more">...more</span>

                                            <?php } ?>

                                    </div>

                                    <?php } else { ?>

                                        <?php } ?>

                        </div>

                    </div>

                    <?php }} ?>

            </div>
        </div>
        <!-- Favourites -->
        <div class="tab-pane fade" id="favouritesBuzz">

            <!--<ul class="nav nav-pills category-tabs mb-3">-->
            <!--    <li class="nav-item">-->
            <!--        <a href="?category=all"-->
            <!--           class="nav-link <?= ($category=='all') ? 'active' : '' ?>">-->
            <!--            All-->
            <!--        </a>-->
            <!--    </li>-->
            
            <!--    <li class="nav-item">-->
            <!--        <a href="?category=education"-->
            <!--           class="nav-link <?= ($category=='education') ? 'active' : '' ?>">-->
            <!--            Education-->
            <!--        </a>-->
            <!--    </li>-->
            
            <!--    <li class="nav-item">-->
            <!--        <a href="?category=healthcare"-->
            <!--           class="nav-link <?= ($category=='healthcare') ? 'active' : '' ?>">-->
            <!--            Healthcare-->
            <!--        </a>-->
            <!--    </li>-->
            
            <!--    <li class="nav-item">-->
            <!--        <a href="?category=realstate"-->
            <!--           class="nav-link <?= ($category=='realstate') ? 'active' : '' ?>">-->
            <!--            Realstate-->
            <!--        </a>-->
            <!--    </li>-->
            
            <!--</ul>-->
            <div class="custom-feed">

                <?php
                $favourites = getFavouriteUpdates(); 

                if(!empty($favourites)){
                foreach($favourites  as $g){
                
                $file = "https://admin.apollosage.in/ash-tracker-admin/uploads/latest_updates/".$g->text_file;
                $ext  = pathinfo($g->text_file, PATHINFO_EXTENSION);
                ?>

                    <div class="news-card">

                        <!-- MEDIA -->
                        <div class="news-media">
                            <!-- BADGE -->
                            <span class="vertical-badge">
                                <?= $g->vertical ?>
                            </span>
                            <?php if($g->type == 'file'){ ?>

                                <?php if(in_array(strtolower($ext),['jpg','jpeg','png','webp'])){ ?>

                                    <img src="<?= $file ?>">

                                    <?php } else if(strtolower($ext) == 'pdf'){ ?>

                                        <div class="file-preview">
                                            <i class="ri-file-pdf-2-fill"></i>

                                            <button class="open-file-btn viewBtn" data-type="pdf" data-file="<?= $file ?>">
                                                Read PDF
                                            </button>
                                        </div>

                                        <?php } else { ?>

                                            <div class="file-preview">
                                                <i class="ri-file-word-2-fill"></i>

                                                <button class="open-file-btn viewBtn" data-type="doc" data-file="<?= $file ?>">
                                                    Open File
                                                </button>
                                            </div>

                                            <?php } ?>

                                                <?php } else { ?>

                                                    <!-- TEXT TYPE -->
                                                    <div class="file-preview">
                                                        <i class="ri-article-fill"></i>
                                                    </div>

                                                    <?php } ?>

                        </div>

                        <!-- CONTENT -->
                        <div class="news-content">

                            <div class="news-header">

                                <div class="news-title">
                                    <?= ucwords($g->title); ?>
                                </div>

                                <div class="fav-btn <?= isFavourite($g->id) ? 'active' : '' ?>"
                                     data-id="<?= $g->id ?>">
                                
                                    <i class="bi <?= isFavourite($g->id) ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                                
                                    <span class="heart-animation"></span>
                                
                                </div>

                            </div>

                            <?php if($g->type == 'text'){ ?>

                                <?php  $text = strip_tags($g->text_file); $short = substr($text,0,120); ?>

                                    <div class="news-text">

                                        <span class="short-text">
                                            <?= $short ?>
                                        </span>

                                        <?php if(strlen($text) > 120){ ?>

                                            <span class="more-text d-none">
                    <?= substr($text,120) ?>
                </span>

                                            <span class="read-more">...more</span>

                                            <?php } ?>

                                    </div>

                                    <?php } else { ?>

                                        <?php } ?>

                        </div>

                    </div>

                    <?php }} ?>
                <?php if(empty($favourites)){ ?>
                <div class="text-center py-5">
                
                    <i class="bi bi-heart"
                       style="font-size:55px;color:#ccc;"></i>
                
                    <h6 class="mt-3 mb-1">
                        No favourites yet
                    </h6>
                
                    <p class="text-muted small">
                        Your liked buzz will appear here.
                    </p>
                
                </div>
                
                <?php } ?>

            </div>
        </div>
        </div>
        <!-- MODAL -->
        <div class="modal fade" id="viewModal" tabindex="-1">
            <div class="modal-dialog  modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-2 text-center" id="modalContent"></div>
                </div>

            </div>
        </div>
    </div>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click','.viewBtn',function(){
    
        let file = $(this).data('file');
        let type = $(this).data('type');
        let text = $(this).data('text');
    
        let ext = '';
    
        if(file){
            ext = file.split('.').pop().toLowerCase();
        }
    
        let html = '';
    
        // TEXT CONTENT
        if(type == 'text'){
    
            html = `
            <div class="text-start p-3">
    
                <div style="
                    font-size:15px;
                    line-height:1.8;
                    color:#444;
                    white-space:pre-line;
                ">
                    ${text}
                </div>
    
            </div>`;
        }
    
        // IMAGE
        else if(['jpg','jpeg','png','webp'].includes(ext)){
    
            html = `
            <img src="${file}" 
                 class="img-fluid rounded">`;
        }
    
        // PDF
        else if(ext == 'pdf'){
    
            html = `
            <iframe src="${file}"
                width="100%"
                height="600px"
                style="border:none;border-radius:12px;">
            </iframe>`;
        }
    
        // DOC FILES
        else if(['doc','docx','xls','xlsx','ppt','pptx'].includes(ext)){
    
            let officeViewer =
            "https://view.officeapps.live.com/op/embed.aspx?src=" 
            + encodeURIComponent(file);
    
            html = `
            <iframe src="${officeViewer}"
                width="100%"
                height="600px"
                style="border:none;border-radius:12px;">
            </iframe>`;
        }
    
        // OTHER
        else{
    
            html = `
            <div class="text-center p-5">
    
                <i class="ri-file-download-line"
                   style="font-size:70px;color:#666;"></i>
    
                <br><br>
    
                <a href="${file}" 
                   target="_blank"
                   class="btn btn-primary rounded-pill px-4">
                   Download File
                </a>
    
            </div>`;
        }
    
        $('#modalContent').html(html);
    
        let modal = new bootstrap.Modal(
            document.getElementById('viewModal')
        );
    
        modal.show();
    
    });
</script>
<script>
    // READ MORE
    $(document).on('click','.read-more',function(){
    
        let parent = $(this).closest('.news-text');
    
        parent.find('.more-text').removeClass('d-none');
    
        $(this).hide();
    
    });
</script>
<script>
    $(document).on('click','.filterBtn',function(){
    
        $('.filterBtn').removeClass('active');
    
        $(this).addClass('active');
    
        let category = $(this).data('category');
    
        $('.news-card').hide();
    
        $('.news-card').each(function(){
    
            let cardCategory = $(this).data('category');
    
            if(cardCategory == category){
    
                $(this).show();
    
            }
    
        });
    
    });
</script>

<script>

$(document).on('click','.fav-btn',function(){

    let btn = $(this);

    let icon = btn.find('i');

    let update_id = btn.data('id');

    $.ajax({

        url:'<?= base_url("toggle-favourite") ?>',
        type:'POST',
        data:{
            update_id:update_id
        },

        success:function(res){

            let data = JSON.parse(res);

            // INSTAGRAM ANIMATION
            btn.addClass('animate');

            setTimeout(function(){

                btn.removeClass('animate');

            },500);


            // ADD FAVOURITE
            if(data.status == 'added'){

                btn.addClass('active');

                icon.removeClass('bi-heart');

                icon.addClass('bi-heart-fill');

            }

            // REMOVE FAVOURITE
            else{

                btn.removeClass('active');

                icon.removeClass('bi-heart-fill');

                icon.addClass('bi-heart');

            }

        }

    });

});

</script>