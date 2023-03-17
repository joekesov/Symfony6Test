<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new user.')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the user.')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the user.')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'If set, the user is created as an admin.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');
        $isAdmin = $input->getOption('admin');

        if (!$email) {
            $email = $io->ask('Please enter an email');
        }

        if (!$plainPassword) {
            $plainPassword = $io->ask('Please enter a password');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles($isAdmin ? ['ROLE_ADMIN'] : ['ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf('User "%s" created.', $email));

        return Command::SUCCESS;
    }

}
