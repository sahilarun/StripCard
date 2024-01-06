class DashBoardModel {
  Message message;
  Data data;

  DashBoardModel({
    required this.message,
    required this.data,
  });

  factory DashBoardModel.fromJson(Map<String, dynamic> json) => DashBoardModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  String defaultImage;
  String imagePath;
  User user;
  String baseCurr;
  UserWallet userWallet;
  String activeVirtualSystem;
  String totalAddMoney;
  int activeCards;
  List<Transaction> transactions;

  Data({
    required this.defaultImage,
    required this.imagePath,
    required this.user,
    required this.baseCurr,
    required this.userWallet,
    required this.activeVirtualSystem,
    required this.totalAddMoney,
    required this.activeCards,
    required this.transactions,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        defaultImage: json["default_image"],
        imagePath: json["image_path"],
        user: User.fromJson(json["user"]),
        baseCurr: json["base_curr"],
        userWallet: UserWallet.fromJson(json["userWallet"]),
        activeVirtualSystem: json["active_virtual_system"],
        totalAddMoney: json["totalAddMoney"],
        activeCards: json["active_cards"],
        transactions: List<Transaction>.from(
            json["transactions"].map((x) => Transaction.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "default_image": defaultImage,
        "image_path": imagePath,
        "user": user.toJson(),
        "base_curr": baseCurr,
        "userWallet": userWallet.toJson(),
        "active_virtual_system": activeVirtualSystem,
        "totalAddMoney": totalAddMoney,
        "active_cards": activeCards,
        "transactions": List<dynamic>.from(transactions.map((x) => x.toJson())),
      };
}

class Transaction {
  int id;
  String type;
  String trx;
  String transactionType;
  String requestAmount;
  String payable;
  String status;
  String remark;
  DateTime dateTime;

  Transaction({
    required this.id,
    required this.type,
    required this.trx,
    required this.transactionType,
    required this.requestAmount,
    required this.payable,
    required this.status,
    required this.remark,
    required this.dateTime,
  });

  factory Transaction.fromJson(Map<String, dynamic> json) => Transaction(
        id: json["id"],
        type: json["type"],
        trx: json["trx"],
        transactionType: json["transaction_type"],
        requestAmount: json["request_amount"],
        payable: json["payable"],
        status: json["status"],
        remark: json["remark"],
        dateTime: DateTime.parse(json["date_time"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "type": type,
        "trx": trx,
        "transaction_type": transactionType,
        "request_amount": requestAmount,
        "payable": payable,
        "status": status,
        "remark": remark,
        "date_time": dateTime.toIso8601String(),
      };
}

class User {
  int id;
  String firstname;
  String lastname;
  String username;
  String email;
  dynamic mobileCode;
  dynamic mobile;
  dynamic fullMobile;
  dynamic refferalUserId;
  dynamic image;
  int status;
  UserAddress address;
  int emailVerified;
  int smsVerified;
  int kycVerified;
  dynamic verCode;
  dynamic verCodeSendAt;
  int twoFactorVerified;
  dynamic deviceId;
  dynamic emailVerifiedAt;
  dynamic deletedAt;
  DateTime createdAt;
  DateTime updatedAt;
  // StripeCardHolders stripeCardHolders;
  String fullname;
  String userImage;
  Status stringStatus;
  Status emailStatus;
  String lastLogin;
  Status kycStringStatus;

  User({
    required this.id,
    required this.firstname,
    required this.lastname,
    required this.username,
    required this.email,
    this.mobileCode,
    this.mobile,
    this.fullMobile,
    required this.refferalUserId,
    this.image,
    required this.status,
    required this.address,
    required this.emailVerified,
    required this.smsVerified,
    required this.kycVerified,
    required this.verCode,
    required this.verCodeSendAt,
    required this.twoFactorVerified,
    required this.deviceId,
    required this.emailVerifiedAt,
    required this.deletedAt,
    required this.createdAt,
    required this.updatedAt,
    // required this.stripeCardHolders,
    required this.fullname,
    required this.userImage,
    required this.stringStatus,
    required this.emailStatus,
    required this.lastLogin,
    required this.kycStringStatus,
  });

  factory User.fromJson(Map<String, dynamic> json) => User(
        id: json["id"],
        firstname: json["firstname"],
        lastname: json["lastname"],
        username: json["username"],
        email: json["email"],
        mobileCode: json["mobile_code"] ?? "",
        mobile: json["mobile"] ?? "",
        fullMobile: json["full_mobile"] ?? "",
        refferalUserId: json["refferal_user_id"],
        image: json["image"] ?? "",
        status: json["status"],
        address: UserAddress.fromJson(json["address"]),
        emailVerified: json["email_verified"],
        smsVerified: json["sms_verified"],
        kycVerified: json["kyc_verified"],
        verCode: json["ver_code"],
        verCodeSendAt: json["ver_code_send_at"],
        twoFactorVerified: json["two_factor_verified"],
        deviceId: json["device_id"],
        emailVerifiedAt: json["email_verified_at"],
        deletedAt: json["deleted_at"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        // stripeCardHolders:
        //     StripeCardHolders.fromJson(json["stripe_card_holders"]),
        fullname: json["fullname"],
        userImage: json["userImage"],
        stringStatus: Status.fromJson(json["stringStatus"]),
        emailStatus: Status.fromJson(json["emailStatus"]),
        lastLogin: json["lastLogin"],
        kycStringStatus: Status.fromJson(json["kycStringStatus"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "firstname": firstname,
        "lastname": lastname,
        "username": username,
        "email": email,
        "mobile_code": mobileCode,
        "mobile": mobile,
        "full_mobile": fullMobile,
        "refferal_user_id": refferalUserId,
        "image": image,
        "status": status,
        "address": address.toJson(),
        "email_verified": emailVerified,
        "sms_verified": smsVerified,
        "kyc_verified": kycVerified,
        "ver_code": verCode,
        "ver_code_send_at": verCodeSendAt,
        "two_factor_verified": twoFactorVerified,
        "device_id": deviceId,
        "email_verified_at": emailVerifiedAt,
        "deleted_at": deletedAt,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        // "stripe_card_holders": stripeCardHolders.toJson(),
        "fullname": fullname,
        "userImage": userImage,
        "stringStatus": stringStatus.toJson(),
        "emailStatus": emailStatus.toJson(),
        "lastLogin": lastLogin,
        "kycStringStatus": kycStringStatus.toJson(),
      };
}

class UserAddress {
  String country;
  String state;
  String city;
  String zip;
  String address;

  UserAddress({
    required this.country,
    required this.state,
    required this.city,
    required this.zip,
    required this.address,
  });

  factory UserAddress.fromJson(Map<String, dynamic> json) => UserAddress(
        country: json["country"],
        state: json["state"],
        city: json["city"],
        zip: json["zip"],
        address: json["address"],
      );

  Map<String, dynamic> toJson() => {
        "country": country,
        "state": state,
        "city": city,
        "zip": zip,
        "address": address,
      };
}

class Status {
  String statusClass;
  String value;

  Status({
    required this.statusClass,
    required this.value,
  });

  factory Status.fromJson(Map<String, dynamic> json) => Status(
        statusClass: json["class"],
        value: json["value"],
      );

  Map<String, dynamic> toJson() => {
        "class": statusClass,
        "value": value,
      };
}

class StripeCardHolders {
  String id;
  String object;
  Billing billing;
  dynamic company;
  int created;
  String email;
  Individual individual;
  bool livemode;
  Metadata metadata;
  String name;
  String phoneNumber;
  List<dynamic> preferredLocales;
  Requirements requirements;
  SpendingControls spendingControls;
  String status;
  String type;

  StripeCardHolders({
    required this.id,
    required this.object,
    required this.billing,
    required this.company,
    required this.created,
    required this.email,
    required this.individual,
    required this.livemode,
    required this.metadata,
    required this.name,
    required this.phoneNumber,
    required this.preferredLocales,
    required this.requirements,
    required this.spendingControls,
    required this.status,
    required this.type,
  });

  factory StripeCardHolders.fromJson(Map<String, dynamic> json) =>
      StripeCardHolders(
        id: json["id"],
        object: json["object"],
        billing: Billing.fromJson(json["billing"]),
        company: json["company"],
        created: json["created"],
        email: json["email"],
        individual: Individual.fromJson(json["individual"]),
        livemode: json["livemode"],
        metadata: Metadata.fromJson(json["metadata"]),
        name: json["name"],
        phoneNumber: json["phone_number"],
        preferredLocales:
            List<dynamic>.from(json["preferred_locales"].map((x) => x)),
        requirements: Requirements.fromJson(json["requirements"]),
        spendingControls: SpendingControls.fromJson(json["spending_controls"]),
        status: json["status"],
        type: json["type"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "object": object,
        "billing": billing.toJson(),
        "company": company,
        "created": created,
        "email": email,
        "individual": individual.toJson(),
        "livemode": livemode,
        "metadata": metadata.toJson(),
        "name": name,
        "phone_number": phoneNumber,
        "preferred_locales": List<dynamic>.from(preferredLocales.map((x) => x)),
        "requirements": requirements.toJson(),
        "spending_controls": spendingControls.toJson(),
        "status": status,
        "type": type,
      };
}

class Billing {
  BillingAddress address;

  Billing({
    required this.address,
  });

  factory Billing.fromJson(Map<String, dynamic> json) => Billing(
        address: BillingAddress.fromJson(json["address"]),
      );

  Map<String, dynamic> toJson() => {
        "address": address.toJson(),
      };
}

class BillingAddress {
  String city;
  String country;
  String line1;
  dynamic line2;
  String postalCode;
  String state;

  BillingAddress({
    required this.city,
    required this.country,
    required this.line1,
    required this.line2,
    required this.postalCode,
    required this.state,
  });

  factory BillingAddress.fromJson(Map<String, dynamic> json) => BillingAddress(
        city: json["city"],
        country: json["country"],
        line1: json["line1"],
        line2: json["line2"],
        postalCode: json["postal_code"],
        state: json["state"],
      );

  Map<String, dynamic> toJson() => {
        "city": city,
        "country": country,
        "line1": line1,
        "line2": line2,
        "postal_code": postalCode,
        "state": state,
      };
}

class Individual {
  CardIssuing cardIssuing;
  Dob dob;
  String firstName;
  String lastName;
  Verification verification;

  Individual({
    required this.cardIssuing,
    required this.dob,
    required this.firstName,
    required this.lastName,
    required this.verification,
  });

  factory Individual.fromJson(Map<String, dynamic> json) => Individual(
        cardIssuing: CardIssuing.fromJson(json["card_issuing"]),
        dob: Dob.fromJson(json["dob"]),
        firstName: json["first_name"],
        lastName: json["last_name"],
        verification: Verification.fromJson(json["verification"]),
      );

  Map<String, dynamic> toJson() => {
        "card_issuing": cardIssuing.toJson(),
        "dob": dob.toJson(),
        "first_name": firstName,
        "last_name": lastName,
        "verification": verification.toJson(),
      };
}

class CardIssuing {
  UserTermsAcceptance userTermsAcceptance;

  CardIssuing({
    required this.userTermsAcceptance,
  });

  factory CardIssuing.fromJson(Map<String, dynamic> json) => CardIssuing(
        userTermsAcceptance:
            UserTermsAcceptance.fromJson(json["user_terms_acceptance"]),
      );

  Map<String, dynamic> toJson() => {
        "user_terms_acceptance": userTermsAcceptance.toJson(),
      };
}

class UserTermsAcceptance {
  int date;
  String ip;
  String userAgent;

  UserTermsAcceptance({
    required this.date,
    required this.ip,
    required this.userAgent,
  });

  factory UserTermsAcceptance.fromJson(Map<String, dynamic> json) =>
      UserTermsAcceptance(
        date: json["date"],
        ip: json["ip"],
        userAgent: json["user_agent"],
      );

  Map<String, dynamic> toJson() => {
        "date": date,
        "ip": ip,
        "user_agent": userAgent,
      };
}

class Dob {
  int day;
  int month;
  int year;

  Dob({
    required this.day,
    required this.month,
    required this.year,
  });

  factory Dob.fromJson(Map<String, dynamic> json) => Dob(
        day: json["day"],
        month: json["month"],
        year: json["year"],
      );

  Map<String, dynamic> toJson() => {
        "day": day,
        "month": month,
        "year": year,
      };
}

class Verification {
  Document document;

  Verification({
    required this.document,
  });

  factory Verification.fromJson(Map<String, dynamic> json) => Verification(
        document: Document.fromJson(json["document"]),
      );

  Map<String, dynamic> toJson() => {
        "document": document.toJson(),
      };
}

class Document {
  dynamic back;
  dynamic front;

  Document({
    required this.back,
    required this.front,
  });

  factory Document.fromJson(Map<String, dynamic> json) => Document(
        back: json["back"],
        front: json["front"],
      );

  Map<String, dynamic> toJson() => {
        "back": back,
        "front": front,
      };
}

class Metadata {
  String celticBankAuthorizedUserTerms;
  String termsAndPrivacyAgreement;

  Metadata({
    required this.celticBankAuthorizedUserTerms,
    required this.termsAndPrivacyAgreement,
  });

  factory Metadata.fromJson(Map<String, dynamic> json) => Metadata(
        celticBankAuthorizedUserTerms:
            json["celtic_bank_authorized_user_terms"],
        termsAndPrivacyAgreement: json["terms_and_privacy_agreement"],
      );

  Map<String, dynamic> toJson() => {
        "celtic_bank_authorized_user_terms": celticBankAuthorizedUserTerms,
        "terms_and_privacy_agreement": termsAndPrivacyAgreement,
      };
}

class Requirements {
  String disabledReason;
  List<dynamic> pastDue;

  Requirements({
    required this.disabledReason,
    required this.pastDue,
  });

  factory Requirements.fromJson(Map<String, dynamic> json) => Requirements(
        disabledReason: json["disabled_reason"],
        pastDue: List<dynamic>.from(json["past_due"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "disabled_reason": disabledReason,
        "past_due": List<dynamic>.from(pastDue.map((x) => x)),
      };
}

class SpendingControls {
  List<dynamic> allowedCategories;
  List<dynamic> blockedCategories;
  List<dynamic> spendingLimits;
  dynamic spendingLimitsCurrency;

  SpendingControls({
    required this.allowedCategories,
    required this.blockedCategories,
    required this.spendingLimits,
    required this.spendingLimitsCurrency,
  });

  factory SpendingControls.fromJson(Map<String, dynamic> json) =>
      SpendingControls(
        allowedCategories:
            List<dynamic>.from(json["allowed_categories"].map((x) => x)),
        blockedCategories:
            List<dynamic>.from(json["blocked_categories"].map((x) => x)),
        spendingLimits:
            List<dynamic>.from(json["spending_limits"].map((x) => x)),
        spendingLimitsCurrency: json["spending_limits_currency"],
      );

  Map<String, dynamic> toJson() => {
        "allowed_categories":
            List<dynamic>.from(allowedCategories.map((x) => x)),
        "blocked_categories":
            List<dynamic>.from(blockedCategories.map((x) => x)),
        "spending_limits": List<dynamic>.from(spendingLimits.map((x) => x)),
        "spending_limits_currency": spendingLimitsCurrency,
      };
}

class UserWallet {
  double balance;
  String currency;

  UserWallet({
    required this.balance,
    required this.currency,
  });

  factory UserWallet.fromJson(Map<String, dynamic> json) => UserWallet(
        balance: json["balance"]?.toDouble(),
        currency: json["currency"],
      );

  Map<String, dynamic> toJson() => {
        "balance": balance,
        "currency": currency,
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
