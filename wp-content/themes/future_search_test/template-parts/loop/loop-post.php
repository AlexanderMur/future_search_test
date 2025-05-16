<?php
$is_liked = likes()->is_user_liked(get_the_ID());
$is_disliked = false;

if (!$is_liked) {
    $is_disliked = likes()->is_user_disliked(get_the_ID());
}

$liked_class = '';
if ($is_liked) {
    $liked_class = 'liked';
}

if ($is_disliked) {
    $liked_class = 'disliked';
}

$rating = likes()->get_rating(get_the_ID());
$vote_color = 'color-secondary';
if ($rating > 0) {
    $vote_color = 'color-success';
} else if ($rating < 0) {
    $vote_color = 'color-danger';
}
?>

<div class="article">

    <div class="article_image">
        <?php echo the_post_thumbnail('medium') ?>
    </div>

    <div class="article_main">
        <p class="text-title"><?php echo get_the_title() ?></p>

        <p class="text-body"><?php echo get_the_excerpt() ?></p>

        <div class="article_info">
            <div class="text-info">
                <span>Автор: </span>
                <span class="color-secondary"><?php echo get_the_author() ?></span>
            </div>

            <div class="article-actions <?php echo $liked_class ?>" data-post_id="<?php echo get_the_ID() ?>">
                
                <button class="control-button like-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <g clip-path="url(#clip0_5570_9)">
                            <path d="M11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22Z" fill="#43B05C"/>
                            <path d="M11 5.72V16.72" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.5 11H5.5" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_5570_9">
                                <rect width="22" height="22" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </button>
                
                <span class="text-warning vote-counter <?php echo $vote_color ?>"><?php echo $rating ?></span>

                <button class="control-button dislike-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <g clip-path="url(#clip0_5570_14)">
                            <path d="M11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22Z" fill="#ED8A19"/>
                            <path d="M16.72 11H5.28" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_5570_14">
                                <rect width="22" height="22" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </button>
            </div>
        </div>

    </div>

</div>