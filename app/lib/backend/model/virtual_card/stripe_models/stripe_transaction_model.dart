
class StripeCardTransactionModel {
  Message message;
  Data data;

  StripeCardTransactionModel({
    required this.message,
    required this.data,
  });

  factory StripeCardTransactionModel.fromJson(Map<String, dynamic> json) =>
      StripeCardTransactionModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  List<dynamic> cardTransactions;

  Data({
    required this.cardTransactions,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        cardTransactions:
            List<dynamic>.from(json["cardTransactions"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "cardTransactions": List<dynamic>.from(cardTransactions.map((x) => x)),
      };
}

class Message {
  List<String> success;

  Message({
    required this.success,
  });

  factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: List<String>.from(json["success"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "success": List<dynamic>.from(success.map((x) => x)),
      };
}
