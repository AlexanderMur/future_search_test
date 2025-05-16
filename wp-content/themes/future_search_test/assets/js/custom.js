function getFormData(object) {
    const formData = new FormData();
    Object.keys(object).forEach(key => formData.append(key, object[key]));
    return formData;
}
function updateVoteColor(counter) {
    let rating = +counter.innerText
    if (rating > 0) {
        counter.classList.add('color-success')
        counter.classList.remove('color-secondary')
        counter.classList.remove('color-danger')
    } else if (rating === 0) {
        counter.classList.remove('color-success')
        counter.classList.add('color-secondary')
        counter.classList.remove('color-danger')
    } else if (rating < 0) {
        counter.classList.remove('color-success')
        counter.classList.remove('color-secondary')
        counter.classList.add('color-danger')
    }
}
document.addEventListener('DOMContentLoaded', function () {
    [...document.querySelectorAll('.like-button')].forEach(button => {
        button.addEventListener('click', function() {
            let event_type = 'like'
            let parent = button.closest('.article-actions')
            let counter = parent.querySelector('.vote-counter')
            let post_id = parent.dataset.post_id
            
            if (parent.classList.contains('liked')) {
                return
            }
            
            if (parent.classList.contains('disliked')) {
                event_type = 'delete_vote'
            }
            fetch(settings.ajax_url,{
                method: "POST",
                body: getFormData({
                    post_id: post_id,
                    action: 'post_like',
                    event_type: event_type
                })
            })
            counter.innerText = +counter.innerText + 1
            if (event_type === 'like') {
                parent.classList.add('liked')
            }
            parent.classList.remove('disliked')
            updateVoteColor(counter)
        })
    });
    [...document.querySelectorAll('.dislike-button')].forEach(button => {
        button.addEventListener('click', function() {
            let event_type = 'dislike'
            let parent = button.closest('.article-actions')
            let counter = parent.querySelector('.vote-counter')
            let post_id = parent.dataset.post_id
            if (parent.classList.contains('liked')) {
                event_type = 'delete_vote'
            }
            if (parent.classList.contains('disliked')) {
                return
            }
            
            
            fetch(settings.ajax_url + '?action=post_like',{
                method: "POST",
                body: getFormData({
                    post_id: post_id,
                    action: 'post_like',
                    event_type: event_type
                })
            })
            counter.innerText = +counter.innerText - 1

            if (event_type === 'dislike') {
                parent.classList.add('disliked')
            }
            parent.classList.remove('liked')
            updateVoteColor(counter)
        })
    });
});