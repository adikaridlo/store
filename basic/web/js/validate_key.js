$('.validate-key').keyup(function(e)
                                {
  if (/\D/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
  }
});

$('.validate-key-mdr').keyup(function(e) {
    match = (/(\d{0,2})[^.]*((?:\.\d{0,3})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
    this.value = match[1] + match[2];
});