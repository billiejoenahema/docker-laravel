function deleteHandle(e) {
  console.log('confirm!')
  e.preventDefault()
  if (window.confirm('メモを削除しますか？')) {
    document.getElementById('delete-form').submit()
  } else {
    return
  }
}
