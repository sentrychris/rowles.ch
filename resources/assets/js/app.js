import 'trumbowyg';
import Swal from 'sweetalert2';
window.swal = Swal;

import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { faEnvelope, faHeart } from '@fortawesome/free-solid-svg-icons';
import { faFacebookF, faGithub, faTwitter } from '@fortawesome/free-brands-svg-icons';

library.add(faEnvelope, faHeart, faFacebookF, faGithub, faTwitter );
dom.watch();

import { notification } from './notification';

const banner = $('.environ-banner');
const app = {
    setActiveMenuItem: items => {
        let path = location.pathname;
        $.each(items, (index, item) => {
            $(item).removeClass('active');
            if ((path.includes($(item).attr('href'))
                && $(item).attr('href') !== "/")
                || ($(item).attr('href') === "/" && path === "/")) {
                $(item).addClass('active')
            }
        })
    },

    removeEnvironBanner: () => {
        banner.remove();
        sessionStorage.setItem("bannerRemoved", true);
    },

    notify: (msg, type) => {
        notification({
            msg: msg,
            type: type,
            position: "center"
        })
    }
};

const blog = {
    describePost: id => {
        let elem = $('.post-' + id + '> .post-content > .blog-post');
        let html = elem.first().text().substring(0, 457) + '...';
        elem.first().html(html);
    },

    submitPost: notify => {
        let id = $('input[name="post-id"]').val();
        let postUrl = '/blog/submit';
        let responseUrl = '/blog';

        let data = {
            author: $('input[name="post-author"]').val(),
            title: $('input[name="post-title"]').val(),
            content: $('#h').val()
        };

        if (typeof id === 'string' && id !== '') {
            Object.assign(data, {id: id});
            postUrl = '/blog/' + id + '/submit';
            responseUrl += '/' + id + '/view';
        }

        swal.fire({
            title: "Finished?",
            text: "You will be able to edit this post later.",
            icon: "success",
            showCancelButton: true
        }).then(response => {
            if (response.value) {
                $.post(postUrl, data, {
                }).done((response) => {
                    localStorage.setItem("notify", notify);
                    localStorage.setItem("message", response.msg);
                    localStorage.setItem("type", response.status);
                    location.replace(responseUrl);
                });
            }
        });
    },

    deletePost: (id, notify) => {
        swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this post.",
            icon: "warning",
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                $.get('/blog/' + id + '/delete', {
                }).done((response) => {
                    localStorage.setItem("notify", notify);
                    localStorage.setItem("message", response.msg);
                    localStorage.setItem("type", response.status);
                    location.replace('/blog');
                });
            } else {
                swal.fire({
                    title: "Your post is safe.",
                    icon: "info"
                });
            }
        });
    }
};

if (sessionStorage.getItem("bannerRemoved")) {
    app.removeEnvironBanner();
}

$(() => {
    banner.click(() => {
        app.removeEnvironBanner();
    });

    app.setActiveMenuItem($('.header .menu li a'));

    if (localStorage.getItem('notify') && localStorage.getItem('message')) {
        app.notify('<b>' + localStorage.getItem("message") + '</b>', localStorage.getItem('type'));
        ['notify', 'message', 'type'].forEach(key => localStorage.removeItem(key));
    }
});

export {
    app,
    blog
};
