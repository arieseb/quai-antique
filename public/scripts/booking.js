const noonDateForm = document.getElementById('noon_booking_date')
const eveningDateForm = document.getElementById('evening_booking_date')
const roomAvailable = document.getElementById('room_available')
const xhr = new XMLHttpRequest()
let guestsResult

if (noonDateForm) {
    noonDateForm.addEventListener('input', () => {
        let date = JSON.stringify({date: noonDateForm.value})
        xhr.open('POST', '/noon_booking_data', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.addEventListener('readystatechange', () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                guestsResult = xhr.response
                roomAvailable.innerText = JSON.parse(guestsResult)
            }
        })
        xhr.send(date)
    })
    window.onload = () => {
        let date = JSON.stringify({date: noonDateForm.value})
        xhr.open('POST', '/noon_booking_data', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.addEventListener('readystatechange', () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                guestsResult = xhr.response
                roomAvailable.innerText = JSON.parse(guestsResult)
            }
        })
        xhr.send(date)
    }
}

if (eveningDateForm) {
    eveningDateForm.addEventListener('input', () => {
        let date = JSON.stringify({date: eveningDateForm.value})
        xhr.open('POST', '/evening_booking_data', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.addEventListener('readystatechange', () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                guestsResult = xhr.response
                roomAvailable.innerText = JSON.parse(guestsResult)
            }
        })
        xhr.send(date)
    })
    window.onload = () => {
        let date = JSON.stringify({date: eveningDateForm.value})
        xhr.open('POST', '/evening_booking_data', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.addEventListener('readystatechange', () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                guestsResult = xhr.response
                roomAvailable.innerText = JSON.parse(guestsResult)
            }
        })
        xhr.send(date)
    }
}