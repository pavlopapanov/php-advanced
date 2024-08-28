# Queryable trait

Розробити трейт для побудови запитів до бази даних.

Додати трейт в клас Model.

В трейті мають бути наступні метод:
- select
- create
- destroy (або delete)
- update (робиться через обʼєкт) (за бажанням, ваша реалізація)
- find
- findBy
- where (робиться через обʼєкт після select)
- всі інші методи які є в моєму трейті

При бажанні можна додати:
- orderBy
- whereNotIn
- andWhere
- orWhere
- join
- groupBy