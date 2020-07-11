export const notification = function (options) {
    function _notification(options) {
        let self = this


        // Add class helper
        self.addClass = (el, cl) => {
            if (el.classList) {
                el.classList.add(cl)
            } else {
                el.className += ' ' + cl
            }
            return el
        }

        // New unique notification ID
        self.newNotificationID = () => {
            return 'notification-' + Date.now()
        }

        // Initialise
        self.init = () => {
            self.id = self.newNotificationID()
            self.availablePositions = ['left', 'center', 'right', 'bottom']

            // Set default options
            self.config = Object.assign({
                'type': 'default',
                'position': 'right',
                'msg': 'This is my default message',
                'opacity': 1,
                'zindex': null,
                'callback': null,
                'clickable': false
            }, options)

            // Set default position if passed position is invalid
            if (self.availablePositions.indexOf(self.config.position) === -1) {
                self.config.position = 'right'
            }

            self.createNotification()
        }

        self.createCloseButton = () => {
            let btn = document.createElement('span');

            self.addClass(btn, 'notification-close')
            btn.innerHTML = '&times;'
            self.dismissOnClick(btn);

            return btn
        }

        self.addStyles = (el, styles) => {
            for (let key in styles) {
                if (styles.hasOwnProperty(key)) {
                    el.style[key] = styles[key]
                }
            }

            return el
        }

        self.setPosition = () => {
            let styles = {}
            let notificationWidth = parseFloat(window.getComputedStyle(self.notification).getPropertyValue('width'))
            let documentWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth

            if (self.config.position === 'center') {
                styles.left = parseInt((documentWidth / 2) - (notificationWidth / 2), 10) + 'px'
            } else {
                styles[self.config.position] = 10 + 'px'
            }

            self.addStyles(self.notification, styles)
        }

        self.dismissOnClick = (el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault()
                self.dismiss()
            })
        }

        self.createNotification = () => {
            let n = document.createElement('div')
            n.id = self.id

            self.addClass(n, 'notification')

            let p = document.createElement('p')
            p.innerHTML = self.config.msg
            n.appendChild(p)

            if (self.config.clickable) {
                n.appendChild(self.createCloseButton())
            }

            let styles = {}

            if (self.config.color) styles.color = self.config.color
            if (self.config.width) styles.width = self.config.width

            if (self.config.bgcolor) {
                styles.backgroundColor = self.config.bgcolor
            }

            if (self.config.opacity < 1) {
                styles.opacity = self.config.opacity
            }

            if (self.config.zindex) {
                styles.zIndex = self.config.zindex
            }

            self.addStyles(n, styles)
            self.addClass(n, self.config.type)
            if (self.config.timeout > 0) {
                self.timer = setTimeout(() => {
                    self.dismiss()
                }, self.config.timeout)
            }

            if (!self.config.clickable) {
                self.dismissOnClick(n)
            }

            self.notification = n
            document.querySelector('body').appendChild(n)
            self.setPosition()

            return n
        }

        self.destroy = () => {
            if (self.timer) {
                clearTimeout(self.timer)
                self.timer = null
            }

            self.addClass(self.notification, 'removing')
            setTimeout(() => {
                if (self.notification && self.notification.parentNode) {
                    self.notification.parentNode.removeChild(self.notification)
                    self.notification = null
                }
                if (typeof self.config.callback === 'function') {
                    self.config.callback.call(self)
                }
            }, 500)
        }

        self.getConfigCopy = () => {
            return Object.assign({'id': self.newNotificationID()}, self.config)
        }

        self.dismiss = () => {
            self.destroy()
        }

        self.init()
    }

    return new _notification(options);
}