

/*
 * Form data validation messages (Parsley)
 */


Parsley.addMessages('custom', {
    defaultMessage: "Giá trị này không hợp lệ.",
    type: {
      email:        "Giá trị này phải là một email.",
      url:          "Giá trị này phải là một url.",
      number:       "Giá trị này phải là một số.",
      integer:      "Giá trị này phải là một số nguyên.",
      digits:       "Giá trị này phải là một chữ số.",
      alphanum:     "Giá trị này bao gồm chữ và số."
    },
    notblank:       "Không được để trống giá trị này.",
    required:       "Bắt buộc nhập giá trị này.",
    pattern:        "Giá trị này không hợp lệ.",
    min:            "Giá trị này phải lớn hơn hoặc bằng %s.",
    max:            "Giá trị này phải thấp hơn hoặc bằng %s.",
    range:          "Giá trị này phải nằm trong khoảng %s đến %s.",
    minlength:      "Giá trị này quá ngắn. Nó phải có %s ký tự trở lên.",
    maxlength:      "Giá trị này quá dài. Nó phải có %s ký tự trở xuống.",
    length:         "Độ dài giá trị này không hợp lệ. Nó phải dài từ %s đến %s ký tự.",
    mincheck:       "Bạn phải chọn ít nhất %s lựa chọn.",
    maxcheck:       "Bạn phải chọn %s lựa chọn hoặc ít hơn.",
    check:          "Bạn phải chọn giữa các lựa chọn %s và %s .",
    equalto:        "Giá trị này phải giống nhau.",
    euvatin:        "Đây không phải là mã số thuế VAT hợp lệ.",
  });
  
  Parsley.setLocale('custom');


