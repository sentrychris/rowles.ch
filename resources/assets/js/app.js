import 'trumbowyg'
import { gsap, SplitText } from "gsap";
import Swal from 'sweetalert2'
import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { faEnvelope, faHeart, faSignOutAlt, faPowerOff } from '@fortawesome/free-solid-svg-icons'
import { faFacebookF, faGithub, faLinkedin, faTwitter } from '@fortawesome/free-brands-svg-icons'
import { notification } from './notification';

window.SplitText = class SplitText {
  #options = {
    charClass: "aki__char",
    wordClass: "aki__word",
    lineClass: "aki__line",
    globalClass: "aki_wrapper",
    emptySpaceName: "__AKI__EMPTY__SPACE__",
  };

  #rawChars = [];
  chars = [];
  #rawWords = [];
  words = [];
  lines = [];

  constructor(elementOrSelector) {
    this.init(elementOrSelector);

    this.target = null;
    this.textContent = null;
  }

  #isElement(obj) {
    try {
      return obj instanceof HTMLElement;
    } catch (e) {
      return (
        typeof obj === "object" &&
        obj.nodeType === 1 &&
        typeof obj.style === "object" &&
        typeof obj.ownerDocument === "object"
      );
    }
  }

  #createElement(tagname, content = "", htmlAttributes = {}, ...cssClass) {
    const __element__ = document.createElement(tagname);
    __element__.classList.add(...cssClass);
    __element__.innerHTML = content;

    for (const [key, value] of Object.entries(htmlAttributes)) {
      __element__.setAttribute(key, value);
    }

    return __element__;
  }

  #splitChars() {
    const textChars = `${this.textContent}`.split("");

    textChars.forEach((char) => {
      const charElement = this.#createElement(
        "div",
        `${char}`,
        {
          style: "position:relative; display:inline-block;",
        },
        `${this.#options.globalClass}`,
        `${this.#options.charClass}`
      );

      this.#rawChars.push(char === " " ? " " : charElement);
      this.chars.push(charElement);
    });
    this.#rawChars.push(" ");
  }

  #splitWords() {
    let startIndex = 0;
    this.#rawChars.forEach((rawChar, index) => {
      if (rawChar === " ") {
        const wordArray = this.#rawChars
          .slice(startIndex, index)
          .filter((word) => word !== " ");

        const wordDiv = this.#createElement(
          "div",
          "",
          {
            style: "position:relative; display:inline-block;",
          },
          `${this.#options.globalClass}`,
          `${this.#options.wordClass}`
        );

        wordArray.forEach((word) => {
          wordDiv.append(word);
        });

        this.words.push(wordDiv);
        this.#rawWords.push(wordDiv, " ");
        startIndex = index;
      }
    });
  }

  #splitLines() {
    let startIndex = 0;
    let lineArrays = [];

    const appendToLineArray = () => {

      lineArrays.forEach((lineArray) => {
        const lineDiv = this.#createElement(
          "div",
          "",
          {
            style: "position:relative; display:inline-block",
          },
          `${this.#options.globalClass}`,
          `${this.#options.lineClass}`
        );
        
        lineArray.forEach(lineWord => {
          lineDiv.append(lineWord)
          lineDiv.append(" ")
        })
        this.lines.push(lineDiv);
        this.target.append(lineDiv);
      });
    };

    this.words.reduce((oldOffsetTop, word, index) => {
      const currentOffsetTop = word.offsetTop;
      
      if (
        (oldOffsetTop !== currentOffsetTop && oldOffsetTop !== null) ||
        index === this.words.length - 1
      ) {
        const computedIndex =
          index === this.words.length - 1 ? index + 1 : index;
        const lineArray = this.words.slice(startIndex, computedIndex);
        lineArrays.push(lineArray);
        startIndex = index;
      }

      return currentOffsetTop;
    }, null);
    
    appendToLineArray();
  }

  #combineAll() {
    this.words.forEach((word) => {
      this.target.append(word);
      this.target.append(" ");
    });
    this.#splitLines();
  }

  #splitStart() {
    this.#splitChars();
    this.#splitWords();
    this.#combineAll();
  }

  #getTextContent() {
    this.textContent = this.target.textContent;
  }

  #clearContent(element) {
    element.innerHTML = "";
  }

  #logError(message) {
    console.error(`${message}`, "color:red", "color:inherit");
  }

  #logAndThrowError(message) {
    if (message.includes("%c")) {
      console.error(`${message}`, "color:red", "color:inherit");
    } else {
      console.error(`${message}`);
    }
    throw "SplitTextException! ⬆️";
  }

  init(elementOrSelector) {
    if (this.#isElement(elementOrSelector)) {
      this.target = elementOrSelector;
      this.#getTextContent();
    } else {
      if (elementOrSelector !== "") {
        const element = document.querySelector(`${elementOrSelector}`);
        if (element) {
          this.target = element;
          this.#getTextContent();
          // window.addEventListener("resize", () => resizeFunction(element))
        } else {
          this.#logAndThrowError(
            `can't found %c${elementOrSelector}%c in DOM tree!`
          );
        }
      } else {
        this.#logAndThrowError(
          `selector is empty! %cplease give a valid%c selector!`
        );
      }
    }

    this.#clearContent(this.target);
    this.#splitStart();
  }
}

window.gsap = gsap;
window.swal = Swal
library.add(faEnvelope, faHeart, faSignOutAlt, faPowerOff, faFacebookF, faGithub, faLinkedin, faTwitter )
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
