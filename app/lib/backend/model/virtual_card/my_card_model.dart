
class MyCardModel {
    MyCardModel({
        required this.message,
        required this.data,
    });

    Message message;
    Data data;

    factory MyCardModel.fromJson(Map<String, dynamic> json) => MyCardModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
    );

    Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
    };
}

class Data {
    Data({
        required this.baseCurr,
        required this.myCards,
        required this.userWallet,
        required this.cardCharge,
        required this.transactions,
    });

    String baseCurr;
    List<MyCard> myCards;
    UserWallet userWallet;
    CardCharge cardCharge;
    List<Transaction> transactions;

    factory Data.fromJson(Map<String, dynamic> json) => Data(
        baseCurr: json["base_curr"],
        myCards: List<MyCard>.from(json["myCards"].map((x) => MyCard.fromJson(x))),
        userWallet: UserWallet.fromJson(json["userWallet"]),
        cardCharge: CardCharge.fromJson(json["cardCharge"]),
        transactions: List<Transaction>.from(json["transactions"].map((x) => Transaction.fromJson(x))),
    );

    Map<String, dynamic> toJson() => {
        "base_curr": baseCurr,
        "myCards": List<dynamic>.from(myCards.map((x) => x.toJson())),
        "userWallet": userWallet.toJson(),
        "cardCharge": cardCharge.toJson(),
        "transactions": List<dynamic>.from(transactions.map((x) => x.toJson())),
    };
}

class CardCharge {
    CardCharge({
        required this.id,
        required this.slug,
        required this.title,
        required this.fixedCharge,
        required this.percentCharge,
        required this.minLimit,
        required this.maxLimit,
    });

    int id;
    String slug;
    String title;
    int fixedCharge;
    int percentCharge;
    int minLimit;
    int maxLimit;

    factory CardCharge.fromJson(Map<String, dynamic> json) => CardCharge(
        id: json["id"],
        slug: json["slug"],
        title: json["title"],
        fixedCharge: json["fixed_charge"],
        percentCharge: json["percent_charge"],
        minLimit: json["min_limit"],
        maxLimit: json["max_limit"],
    );

    Map<String, dynamic> toJson() => {
        "id": id,
        "slug": slug,
        "title": title,
        "fixed_charge": fixedCharge,
        "percent_charge": percentCharge,
        "min_limit": minLimit,
        "max_limit": maxLimit,
    };
}

class MyCard {
    MyCard({
        required this.id,
        required this.name,
        required this.cardPan,
        required this.cardId,
        required this.expiration,
        required this.cvv,
        required this.amount,
        required this.cardBackDetails,
        required this.siteTitle,
        required this.siteLogo,
        required this.statusInfo,
    });

    int id;
    String name;
    String cardPan;
    String cardId;
    String expiration;
    String cvv;
    double amount;
    String cardBackDetails;
    String siteTitle;
    String siteLogo;
    MyCardStatusInfo statusInfo;

    factory MyCard.fromJson(Map<String, dynamic> json) => MyCard(
        id: json["id"],
        name: json["name"],
        cardPan: json["card_pan"],
        cardId: json["card_id"],
        expiration: json["expiration"],
        cvv: json["cvv"],
        amount: json["amount"]?.toDouble(),
        cardBackDetails: json["card_back_details"],
        siteTitle: json["site_title"],
        siteLogo: json["site_logo"],
        statusInfo: MyCardStatusInfo.fromJson(json["status_info"]),
    );

    Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "card_pan": cardPan,
        "card_id": cardId,
        "expiration": expiration,
        "cvv": cvv,
        "amount": amount,
        "card_back_details": cardBackDetails,
        "site_title": siteTitle,
        "site_logo": siteLogo,
        "status_info": statusInfo.toJson(),
    };
}

class MyCardStatusInfo {
    MyCardStatusInfo({
        required this.block,
        required this.unblock,
    });

    int block;
    int unblock;

    factory MyCardStatusInfo.fromJson(Map<String, dynamic> json) => MyCardStatusInfo(
        block: json["block"],
        unblock: json["unblock"],
    );

    Map<String, dynamic> toJson() => {
        "block": block,
        "unblock": unblock,
    };
}

class Transaction {
    Transaction({
        required this.id,
        required this.trx,
        required this.transactinType,
        required this.requestAmount,
        required this.payable,
        required this.totalCharge,
        required this.cardAmount,
        required this.cardNumber,
        required this.currentBalance,
        required this.status,
        required this.dateTime,
        required this.statusInfo,
    });

    int id;
    String trx;
    String transactinType;
    String requestAmount;
    String payable;
    String totalCharge;
    String cardAmount;
    String cardNumber;
    String currentBalance;
    String status;
    DateTime dateTime;
    TransactionStatusInfo statusInfo;

    factory Transaction.fromJson(Map<String, dynamic> json) => Transaction(
        id: json["id"],
        trx: json["trx"],
        transactinType: json["transactin_type"],
        requestAmount: json["request_amount"],
        payable: json["payable"],
        totalCharge: json["total_charge"],
        cardAmount: json["card_amount"],
        cardNumber: json["card_number"],
        currentBalance: json["current_balance"],
        status: json["status"],
        dateTime: DateTime.parse(json["date_time"]),
        statusInfo: TransactionStatusInfo.fromJson(json["status_info"]),
    );

    Map<String, dynamic> toJson() => {
        "id": id,
        "trx": trx,
        "transactin_type": transactinType,
        "request_amount": requestAmount,
        "payable": payable,
        "total_charge": totalCharge,
        "card_amount": cardAmount,
        "card_number": cardNumber,
        "current_balance": currentBalance,
        "status": status,
        "date_time": dateTime.toIso8601String(),
        "status_info": statusInfo.toJson(),
    };
}

class TransactionStatusInfo {
    TransactionStatusInfo({
        required this.success,
        required this.pending,
        required this.rejected,
    });

    int success;
    int pending;
    int rejected;

    factory TransactionStatusInfo.fromJson(Map<String, dynamic> json) => TransactionStatusInfo(
        success: json["success"],
        pending: json["pending"],
        rejected: json["rejected"],
    );

    Map<String, dynamic> toJson() => {
        "success": success,
        "pending": pending,
        "rejected": rejected,
    };
}


class Status {
    Status({
        required this.statusClass,
        required this.value,
    });

    String statusClass;
    String value;

    factory Status.fromJson(Map<String, dynamic> json) => Status(
        statusClass: json["class"],
        value: json["value"],
    );

    Map<String, dynamic> toJson() => {
        "class": statusClass,
        "value": value,
    };
}

class UserWallet {
    UserWallet({
        required this.balance,
        required this.currency,
    });

    dynamic balance;
    String currency;

    factory UserWallet.fromJson(Map<String, dynamic> json) => UserWallet(
        balance: json["balance"],
        currency: json["currency"],
    );

    Map<String, dynamic> toJson() => {
        "balance": balance,
        "currency": currency,
    };
}

class Message {
    Message({
        required this.success,
    });

    List<String> success;

    factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: List<String>.from(json["success"].map((x) => x)),
    );

    Map<String, dynamic> toJson() => {
        "success": List<dynamic>.from(success.map((x) => x)),
    };
}
