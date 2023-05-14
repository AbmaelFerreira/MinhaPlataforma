// Probably in app/javascript/controllers/index.js

import { Application } from '@hotwired/stimulus'
import Clipboard from 'stimulus-clipboard'

const application = Application.start()
application.register('clipboard', Clipboard)