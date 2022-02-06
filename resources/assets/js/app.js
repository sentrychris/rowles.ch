import 'trumbowyg'
import Swal from 'sweetalert2'
import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { faEnvelope, faHeart, faSignOutAlt, faPowerOff } from '@fortawesome/free-solid-svg-icons'
import { faFacebookF, faGithub, faTwitter } from '@fortawesome/free-brands-svg-icons'
import { notification } from './notification'

window.swal = Swal
library.add(faEnvelope, faHeart, faSignOutAlt, faPowerOff, faFacebookF, faGithub, faTwitter )
dom.watch()

function setNotificationPersist(data, notify) {
    localStorage.setItem('notify', notify)
    localStorage.setItem('message', data.message)
    localStorage.setItem('type', data.status)
}

export const app = {
    setActiveMenuItem: items => {
        const path = location.pathname
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
}

export const blog = {
    describePost: (id) => {
        const elem = document.querySelector('.post-' + id + '> .post-content > .blog-post')
        if (elem) {
            elem.textContent = elem.textContent.substring(0, 457) + '...'
        }
    },

    submitPost: async (notify) => {
        let id = document.querySelector('input[name="post-id"]')
        let postUrl = '/blog/submit'
        let responseUrl = '/blog'

        const data = {
            author: document.querySelector('input[name="post-author"]').value,
            title: document.querySelector('input[name="post-title"]').value,
            content: document.querySelector('#h').value
        }

        if (id) {
            id = id.value
            if (id !== '') {
                Object.assign(data, {id})
                postUrl = '/blog/' + id + '/submit'
                responseUrl += '/' + id + '/view'
            }
        }

        const check = await swal.fire({
            title: 'Finished?',
            text: 'You will be able to edit this post later.',
            icon: 'success',
            showCancelButton: true
        })

        if (check.isConfirmed) {
            const body = new FormData()
            for (const field in data) {
                body.append(field, data[field])
            }

            const response = await fetch(postUrl, {
                method: 'POST',
                body
            })

            if (response.ok) {
                setNotificationPersist(await response.json(), notify)
                location.replace(responseUrl)
            }
        }
    },

    deletePost: async (id, notify) => {
        const check = await swal.fire({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this post.',
            icon: 'warning',
            showCancelButton: true
        })

        if (check.isConfirmed) {
            const response = await fetch(`/blog/${id}/delete`, {
                method: 'DELETE'
            })

            if (response.ok) {
                setNotificationPersist(await response.json(), notify)
                location.replace('/blog')
            }
        } else {
            await swal.fire({
                title: 'Your post is safe.',
                icon: 'info'
            })
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    app.setActiveMenuItem(document.querySelectorAll('.header .menu li a'))

    if (localStorage.getItem('notify') && localStorage.getItem('message')) {
        const type = localStorage.getItem('type')
        const message = '<b>' + localStorage.getItem('message') + '</b>'
        app.notify(message, type)

        for (const key of ['notify', 'message', 'type']) {
            localStorage.removeItem(key)
        }
    }
})
