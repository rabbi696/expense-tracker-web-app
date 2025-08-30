<center> <a href="https://deepwiki.com/rabbi696/expense-tracker-web-app"><img src="https://deepwiki.com/badge.svg" alt="Ask DeepWiki"></a> </center>
</br>

# Expense Tracker Web App

A comprehensive Laravel-based web application for managing personal and business expenses, income tracking, bills management, and financial reporting. Perfect for individuals, families, or small teams who want to maintain detailed financial records and generate insightful reports.

<p align="center">
  <img src="https://iili.io/F09Slbp.png" width="150" alt="Expense Tracker Web App">
</p>

## 🚀 Features

### 📊 Dashboard & Overview
- **Financial Summary**: Real-time overview of total expenses, income, and net cash flow
- **Category Breakdown**: Visual breakdown of expenses by category for the current month
- **Recent Transactions**: Quick view of recent expenses and income entries
- **Monthly Analytics**: Track your financial health at a glance

### 💰 Expense Management
- **Complete CRUD Operations**: Add, view, edit, and delete expenses with ease
- **Advanced Filtering**: Filter expenses by:
  - Category
  - Assigned user
  - Amount range (min/max)
  - Date range
  - Purchase location (Supershop, eCommerce, Bazar)
  - Keyword search in descriptions
- **Receipt Management**: Upload and store receipt images
- **Group Expenses**: Track shared expenses among multiple users
- **Purchase Tracking**: Record where purchases were made

### 📈 Income Tracking
- **Income Management**: Add, edit, and delete income entries
- **User Assignment**: Track income assigned to specific users
- **Date-based Organization**: Organize income by date for better tracking
- **Notes Support**: Add detailed notes to income entries

### 🏷️ Category Management
- **Custom Categories**: Create, edit, and delete expense categories
- **Category Analytics**: View spending breakdown by category
- **Flexible Organization**: Organize expenses with custom categories

### 📋 Bills & Invoices
- **Bill Management**: Track recurring bills with due dates
- **Bill Frequency**: Set bills as daily, weekly, monthly, quarterly, or yearly
- **Payment Status**: Mark bills as paid or unpaid
- **Invoice Management**: Create and track invoices with unique numbers
- **Invoice Status**: Track invoice status (pending, paid, overdue)

### 📊 Advanced Reporting
- **Monthly Reports**: Detailed monthly expense summaries with category breakdowns
- **User Reports**: Individual user expense reports with detailed analytics
- **Expense Trends**: Analyze spending patterns over time
- **Cash Flow Reports**: Track income vs expenses with net cash flow analysis
- **Export Capabilities**: Export all reports to Excel, CSV, or PDF formats

### 👥 User Management
- **Role-based Access**: Admin and regular user roles
- **Multi-user Support**: Manage expenses for multiple users
- **User Authentication**: Secure login/logout system
- **Profile Management**: Edit user profiles and change passwords
- **Admin Controls**: Admin users can manage other users

### 🧮 Additional Features
- **Built-in Calculator**: Perform calculations directly within the app
- **Notes System**: Keep track of important financial notes
- **Responsive Design**: Works seamlessly on desktop and mobile devices

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 12.x (PHP 8.2+)
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Laravel Policies for access control

### Frontend
- **Views**: Blade Templates
- **Styling**: Bootstrap 5.2.3 + Custom SASS
- **JavaScript**: Vanilla JavaScript with Axios for AJAX
- **Build Tool**: Vite 6.2.4

### Key Dependencies
- **Laravel UI**: For authentication scaffolding
- **Maatwebsite Excel**: For report exports (Excel, CSV, PDF)
- **Laravel Tinker**: For database interactions and debugging

### Development Tools
- **Package Manager**: Composer (PHP) + NPM (JavaScript)
- **Task Runner**: Laravel Artisan commands
- **Code Quality**: Laravel Pint for code formatting
- **Testing**: PHPUnit for automated testing

## 📥 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite (or MySQL/PostgreSQL if preferred)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/expense-tracker-web-app.git
   cd expense-tracker-web-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Visit the application**
   Open [http://localhost:8000](http://localhost:8000) in your browser.

### Default Admin User
After seeding, you can log in with:
- **Email**: Check the `AdminUserSeeder.php` file for default credentials
- **Password**: Check the seeder file for the default password

## 🚀 Usage

### Quick Start
1. **Login** with your credentials
2. **Set up categories** for your expenses
3. **Add your first expense** with amount, category, and description
4. **Track income** to balance your cash flow
5. **View reports** to analyze your spending patterns

### Managing Expenses
- Navigate to **Expenses** to add, edit, or delete expenses
- Use **filters** to find specific expenses quickly
- Upload **receipts** for better record keeping
- Assign expenses to **different users** for shared expense tracking

### Generating Reports
- **Monthly Reports**: View spending by month and category
- **User Reports**: See individual user spending and balances
- **Trends**: Analyze spending patterns over time
- **Cash Flow**: Track income vs expenses
- **Export**: Download reports in Excel, CSV, or PDF format

## 🔧 Configuration

### Environment Variables
Key environment variables in `.env`:
```env
APP_NAME="Expense Tracker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### Database Configuration
The app uses SQLite by default, but you can configure it for MySQL or PostgreSQL by updating the `.env` file and running migrations.

## 👥 Contributing

We welcome contributions! Here's how you can help:

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. **Commit your changes**
   ```bash
   git commit -m 'Add some amazing feature'
   ```
4. **Push to the branch**
   ```bash
   git push origin feature/amazing-feature
   ```
5. **Open a Pull Request**

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use meaningful commit messages

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

For specific test types:
```bash
# Feature tests
php artisan test --testsuite=Feature

# Unit tests
php artisan test --testsuite=Unit
```

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/your-username/expense-tracker-web-app/issues) page
2. Create a new issue with detailed information
3. Provide steps to reproduce any bugs

## 🔮 Roadmap

Planned features for future releases:
- [ ] API endpoints for mobile app integration
- [ ] Budget planning and alerts
- [ ] Recurring expense automation
- [ ] Advanced analytics with charts
- [ ] Multi-currency support
- [ ] Data import/export from other financial apps
- [ ] Mobile responsive improvements
- [ ] Real-time notifications

## 📊 Database Schema

### Core Tables
- **users**: User accounts with roles and monthly allocations
- **categories**: Expense categories for organization
- **expenses**: Main expense records with amounts, dates, and descriptions
- **incomes**: Income tracking with user assignments
- **bills**: Recurring bill management
- **invoices**: Invoice tracking with status management

### Key Relationships
- Users have many expenses, incomes, bills, and invoices
- Expenses belong to categories and users
- Expenses can be assigned to different users (shared expenses)
- Bills and invoices are owned by users

---

*Built with ❤️ using Laravel*
