package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.CreateUserRequest;
import gr.uowm.iroom.entity.Department;
import gr.uowm.iroom.entity.Password;
import gr.uowm.iroom.entity.User;
import gr.uowm.iroom.exception.BadRequestException;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.DepartmentRepository;
import gr.uowm.iroom.repository.PasswordRepository;
import gr.uowm.iroom.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class UserService {

    private final UserRepository userRepository;
    private final PasswordRepository passwordRepository;
    private final DepartmentRepository departmentRepository;
    private final PasswordEncoder passwordEncoder;

    @Transactional
    public User createUser(CreateUserRequest request) {
        // Check if email already exists
        if (userRepository.findByEmail(request.getEmail()).isPresent()) {
            throw new BadRequestException("Email already exists: " + request.getEmail());
        }

        // Get department
        Department department = departmentRepository.findById(request.getDepartmentId())
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + request.getDepartmentId()));

        // Create user
        User user = User.builder()
                .name(request.getName())
                .lastName(request.getLastName())
                .phone(request.getPhone())
                .email(request.getEmail())
                .department(department)
                .userType(request.getUserType())
                .ssoId(request.getSsoId())
                .build();

        user = userRepository.save(user);

        // Create password entry
        Password password = Password.builder()
                .user(user)
                .passwordHash(passwordEncoder.encode(request.getPassword()))
                .build();

        passwordRepository.save(password);

        return user;
    }

    public List<User> getAllUsers() {
        return userRepository.findAll();
    }

    public User getUserById(Long id) {
        return userRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("User not found with id: " + id));
    }

    @Transactional
    public void deleteUser(Long id) {
        User user = getUserById(id);
        userRepository.delete(user);
    }

    @Transactional
    public User updateUser(Long id, CreateUserRequest request) {
        User user = getUserById(id);

        // Check if email is being changed and if new email already exists
        if (!user.getEmail().equals(request.getEmail()) &&
                userRepository.findByEmail(request.getEmail()).isPresent()) {
            throw new BadRequestException("Email already exists: " + request.getEmail());
        }

        // Get department
        Department department = departmentRepository.findById(request.getDepartmentId())
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + request.getDepartmentId()));

        user.setName(request.getName());
        user.setLastName(request.getLastName());
        user.setPhone(request.getPhone());
        user.setEmail(request.getEmail());
        user.setDepartment(department);
        user.setUserType(request.getUserType());
        user.setSsoId(request.getSsoId());

        // Update password if provided
        if (request.getPassword() != null && !request.getPassword().isEmpty()) {
            Password password = passwordRepository.findByUserId(user.getId())
                    .orElseThrow(() -> new ResourceNotFoundException("Password not found for user: " + id));
            password.setPasswordHash(passwordEncoder.encode(request.getPassword()));
            passwordRepository.save(password);
        }

        return userRepository.save(user);
    }
}
