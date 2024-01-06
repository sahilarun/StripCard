class ErrorResponse {
  ErrorResponse({
    required this.message,
  });

  late final Message message;

  ErrorResponse.fromJson(Map<String, dynamic> json) {
    message = Message.fromJson(json['message']);
  }

  Map<String, dynamic> toJson() {
    final data = <String, dynamic>{};
    data['message'] = message.toJson();
    return data;
  }
}

class Message {
  Message({
    required this.error,
  });

  late final List<String> error;

  Message.fromJson(Map<String, dynamic> json) {
    error = List.castFrom<dynamic, String>(json['error']);
  }

  Map<String, dynamic> toJson() {
    final data = <String, dynamic>{};
    data['error'] = error;
    return data;
  }
}

// import 'dart:convert';
//
// ErrorResponse errorResponseFromJson(String str) =>
//     ErrorResponse.fromJson(json.decode(str));
//
// String errorResponseToJson(ErrorResponse data) => json.encode(data.toJson());
//
// class ErrorResponse {
//   ErrorResponse({
//     this.data,
//     required this.message,
//   });
//
//   dynamic data;
//   Message message;
//
//   factory ErrorResponse.fromJson(Map<String, dynamic> json) => ErrorResponse(
//         data: json["data"],
//         message: Message.fromJson(json["message"]),
//       );
//
//   Map<String, dynamic> toJson() => {
//         "data": data,
//         "message": message.toJson(),
//       };
// }
//
// class Message {
//   Message({
//     required this.error,
//   });
//
//   List<String> error;
//
//   factory Message.fromJson(Map<String, dynamic> json) => Message(
//         error: List<String>.from(json["error"].map((x) => x)),
//       );
//
//   Map<String, dynamic> toJson() => {
//         "error": List<dynamic>.from(error.map((x) => x)),
//       };
// }
