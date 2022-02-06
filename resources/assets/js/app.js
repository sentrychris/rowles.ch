import 'trumbowyg';
import Swal from 'sweetalert2';
window.swal = Swal;

import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { faEnvelope, faHeart, faSignOutAlt, faPowerOff } from '@fortawesome/free-solid-svg-icons';
import { faFacebookF, faGithub, faTwitter } from '@fortawesome/free-brands-svg-icons';

library.add(faEnvelope, faHeart, faSignOutAlt, faPowerOff, faFacebookF, faGithub, faTwitter );
dom.watch();

import { notification } from './notification';

const app = {
    setActiveMenuItem: items => {
        const path = location.pathname;
        for (const item of items) {
            item.classList.remove('active')
            const uri = item.href.split('/').pop()
            if ((path.includes(uri) && uri !== '') || (uri === '' && path === '/')) {
                item.classList.add('active')
            }
        }
    },

    notify: (message, type, position = null) => {
        notification({
            message: message,
            type: type,
            position: position ? position : 'center'
        })
    }
};

const blog = {
    describePost: id => {
        const elem = document.querySelector('.post-' + id + '> .post-content > .blog-post')
        if (elem) {
            elem.textContent = elem.textContent.substring(0, 457) + '...'
        }
    },

    submitPost: notify => {
        let id = document.querySelector('input[name="post-id"]')
        let postUrl = '/blog/submit'
        let responseUrl = '/blog'

        const data = {
            author: document.querySelector('input[name="post-author"]').value,
            title: document.querySelector('input[name="post-title"]').value,
            content: document.querySelector('#h').value
        };

        if (id) {
            id = id.value
            if (id !== '') {
                Object.assign(data, {id})
                postUrl = '/blog/' + id + '/submit'
                responseUrl += '/' + id + '/view'
            }
        }

        swal.fire({
            title: "Finished?",
            text: "You will be able to edit this post later.",
            icon: "success",
            showCancelButton: true
        }).then(response => {
            if (response.value) {
                const body = new FormData()
                for (const field in data) {
                    body.append(field, data[field])
                }

                fetch(postUrl, { method: 'POST', body})
                    .then((response) => {
                        return response.json()
                    })
                    .then((data) => {
                        setNotificationPersist(data, notify)
                        location.replace(responseUrl)
                    })
            }
        });
    },

    deletePost: async (id, notify) => {
        const confirmation = await swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this post.",
            icon: "warning",
            showCancelButton: true
        })

        if (confirmation.value) {
            const response = await fetch(`/blog/${id}/delete`, {
                method: 'DELETE'
            })

            if (response.ok) {
                setNotificationPersist(await response.json(), notify)
                location.replace('/blog')
            }
        } else {
            await swal.fire({
                title: "Your post is safe.",
                icon: "info"
            })
        }
    }
};

function setNotificationPersist(data, notify) {
    localStorage.setItem("notify", notify)
    localStorage.setItem("message", data.message)
    localStorage.setItem("type", data.status)
}

document.addEventListener('DOMContentLoaded', () => {
    app.setActiveMenuItem(document.querySelectorAll('.header .menu li a'));

    if (localStorage.getItem('notify') && localStorage.getItem('message')) {
        const type = localStorage.getItem('type')
        const message = '<b>' + localStorage.getItem("message") + '</b>'
        app.notify(message, type);

        for (const key of ['notify', 'message', 'type']) {
            localStorage.removeItem(key)
        }
    }
})

export {
    app,
    blog
};
